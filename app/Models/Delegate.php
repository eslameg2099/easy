<?php

namespace App\Models;

use Parental\HasParent;
use App\Events\BalanceCollected;
use Illuminate\Support\Facades\DB;
use App\Http\Filters\DelegateFilter;
use App\Events\DelegateBalanceCollected;
use App\Http\Resources\DelegateResource;
use App\Models\Relations\DelegateRelations;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Delegate extends User
{
    use HasFactory;
    use HasParent;
    use DelegateRelations;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'city_id',
        'remember_token',
        'national_id',
        'vehicle_type',
        'vehicle_model',
        'vehicle_number',
        'is_available',
        'lat',
        'lng',
    ];
    /**
     * The model filter name.
     *
     * @var string
     */
    protected $filter = DelegateFilter::class;

    /**
     * Get the class name for polymorphic relations.
     *
     * @return string
     */
    public function getMorphClass()
    {
        return User::class;
    }

    /**
     * Get the default foreign key name for the model.
     *
     * @return string
     */
    public function getForeignKey()
    {
        return 'user_id';
    }

    /**
     * @return \App\Http\Resources\DelegateResource
     */
    public function getResource()
    {
        return new DelegateResource($this);
    }

    /**
     * Get the dashboard profile link.
     *
     * @return string
     */
    public function dashboardProfile(): string
    {
        return route('dashboard.delegates.show', $this);
    }

    /**
     * Define the media collections.
     *
     * @return void
     */
    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('avatars')
            ->useFallbackUrl('https://www.gravatar.com/avatar/'.md5($this->email).'?d=mm')
            ->singleFile()
            ->registerMediaConversions(function () {
                $this->addMediaConversion('thumb')->width(70)->format('png');
                $this->addMediaConversion('small')->width(120)->format('png');
                $this->addMediaConversion('medium')->width(160)->format('png');
                $this->addMediaConversion('large')->width(320)->format('png');
            });

        $this->addMediaCollection('national_front_image')->singleFile();
        $this->addMediaCollection('national_back_image')->singleFile();
        $this->addMediaCollection('vehicle_image')->singleFile();
    }

    /**
     * Get the orders assigned to the delegate.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function shopOrders()
    {
        return $this->hasMany(ShopOrder::class, 'delegate_id');
    }

    /**
     * Get all the delegate's collects.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function collects()
    {
        return $this->hasMany(DelegateCollect::class, 'delegate_id');
    }

    /**
     * Collect the due balance.
     *
     * @throws \Throwable
     * @return $this
     */
    public function collect()
    {
        $query = $this->shopOrders()->where('status', Order::DELIVERED_STATUS)->whereNull('delegate_collected_at');

        DB::beginTransaction();
        try {
            $balance = (clone $query)->sum('total');

            if ($balance <= 0) {
                return $this;
            }

            $now = now();

            /** @var \App\Models\DelegateCollect $collect */
            $collect = $this->collects()->create([
                'amount' => $balance,
                'date' => $now,
            ]);

            (clone $query)
                ->update([
                    'delegate_collected_at' => $now,
                ]);

            DB::commit();

            event(new DelegateBalanceCollected($collect));
        } catch (\Exception $exception) {
            DB::rollBack();
        }

        return $this;
    }

    /**
     * Get the readable status for delegates.
     *
     * @param $status
     * @return string
     */
    public function getReadableStatus($status)
    {
        switch ($status) {
            case Order::PENDING_STATUS:
            case Order::IN_PROGRESS_STATUS:
            case Order::WAITING_DELIVER_STATUS:
            case Order::ASSIGNED_TO_DELEGATE_STATUS:
            case Order::DELIVERED_TO_DELEGATE:
                return trans('orders.statuses.'.Order::PENDING_STATUS);
            case Order::DELIVERING_STATUS:
            case Order::DELIVERING_TO_DELEGATE:
                return trans('orders.statuses.'.Order::DELIVERING_STATUS);
            case Order::DELIVERED_STATUS:
                return trans('orders.statuses.'.Order::DELIVERED_STATUS);
        }
    }
}
