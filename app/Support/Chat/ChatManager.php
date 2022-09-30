<?php

namespace App\Support\Chat;

use App\Models\User;
use App\Models\ChatRoom;
use Illuminate\Support\Arr;
use App\Models\ChatRoomMessage;
use App\Support\Chat\Events\RoomAdded;
use App\Support\Chat\Events\MessageRead;
use App\Support\Chat\Events\MessageSent;
use Illuminate\Database\Eloquent\Builder;
use App\Support\Chat\Contracts\ChatMember;
use Illuminate\Database\Eloquent\Collection;
use App\Support\Chat\Exceptions\InvalidMemberType;

class ChatManager
{
    /**
     * The instance of authenticated user.
     *
     * @var \App\Models\User
     */
    protected $user;

    /**
     * Create user instance.
     */
    public function __construct()
    {
        $this->user = auth()->user();
    }

    /**
     * @return \Illuminate\Contracts\Pagination\Paginator
     */
    public function getRooms()
    {
        return ChatRoom::filter()->has('model')->whereHas('roomMembers', function ($query) {
            $query->where('member_id', $this->user->id);
        })
            ->latest('updated_at')
            ->simplePaginate();
    }

    /**
     * @return \Illuminate\Contracts\Pagination\Paginator
     */
    public function getContacts()
    {
        return User::query()
            ->where('id', '!=', $this->user->id)
            ->whereDoesntHave('roomsMember.room', function (Builder $builder) {
                $builder->whereHas('roomMembers', function ($query) {
                    $query->where('member_id', $this->user->id);
                });
            })
            ->simplePaginate();
    }

    /**
     * @param iterable|\App\Support\Chat\Contracts\ChatMember $members
     * @param array $data
     * @throws \Exception
     * @return \App\Models\ChatRoom|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object
     */
    public function getRoomWith($members, $data = [])
    {
        $members = $this->qualifyMembers($members);

        $room = ChatRoom::query()
            ->has('roomMembers', '=', count($members))
            ->where($data)
            ->where(function (Builder $builder) use ($members) {
                foreach ($members as $member) {
                    $builder->whereHas('roomMembers', function ($query) use ($member) {
                        $query->where('member_id', $member->id);
                    });
                }
            })
            ->first();

        return $room ?: $this->addRoom($members, $data);
    }

    protected function addRoom(iterable $members, $data = [])
    {
        $room = ChatRoom::create($data);

        $members->each(function ($member) use ($room) {
            $room->roomMembers()->create([
                'member_id' => $member->id,
            ]);
        });

        event(new RoomAdded($room));

        return $room;
    }

    /**
     * Ensure that the given members are valid.
     *
     * @param iterable|ChatMember $members
     * @throws \Exception
     * @return \Illuminate\Database\Eloquent\Collection
     */
    protected function qualifyMembers($members): iterable
    {
        $members = Collection::make(Arr::wrap($members))->prepend($this->user);

        foreach ($members as $member) {
            if (! $member instanceof ChatMember) {
                throw new InvalidMemberType;
            }
        }

        return $members;
    }

    /**
     * @return \App\Models\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param \App\Models\User|\Illuminate\Contracts\Auth\Authenticatable $user
     * @return $this
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @param \App\Models\ChatRoom $room
     * @param string $message
     * @param null $file
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig
     * @return \App\Models\ChatRoomMessage
     */
    public function sendMessage(ChatRoom $room, $message = '', $file = null)
    {
        /** @var ChatRoomMessage $chatMessage */
        $chatMessage = $room->messages()->create([
            'sender_id' => $this->getUser()->id,
            'message' => $message,
        ]);

        if ($file) {
            $chatMessage->addMedia($file)->toMediaCollection();
        }

        broadcast(new MessageSent($chatMessage))->toOthers();

        $this->markAsRead($room, $chatMessage);

        return $chatMessage->refresh();
    }

    public function markAsRead(ChatRoom $room, ChatRoomMessage $chatRoomMessage = null)
    {
        $currentMember = $room->roomMembers->where('member_id', $this->user->id)->first();

        $message = $chatRoomMessage ?: $room->lastMessage;

        if (! $message || ! $currentMember) {
            return $this;
        }
        if ($currentMember->last_read_message_id == $message->id) {
            return $this;
        }

        $currentMember->forceFill([
            'last_read_message_id' => $message->id,
            'read_at' => now(),
        ])->save();

        broadcast(new MessageRead($message))->toOthers();

        return $this;
    }
}
