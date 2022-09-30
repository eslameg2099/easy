<?php

namespace App\Models;

use App\Http\Filters\Filterable;
use App\Http\Filters\ReportFilter;
use App\Support\Traits\Selectable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Report extends Model
{
    use HasFactory;
    use Filterable;
    use Selectable;

    /**
     * The query parameter's filter of the model.
     *
     * @var string
     */
    protected $filter = ReportFilter::class;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'shop_order_id',
        'message',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'read_at' => 'datetime',
    ];

    /**
     * Determine whither the message was read.
     *
     * @return bool
     */
    public function read()
    {
        return ! ! $this->read_at;
    }

    /**
     * Mark the message as read.
     *
     * @return $this
     */
    public function markAsRead()
    {
        if (! $this->read()) {
            $this->forceFill(['read_at' => now()])->save();
        }

        return $this;
    }

    /**
     * Mark the message as unread.
     *
     * @return $this
     */
    public function markAsUnread()
    {
        if ($this->read()) {
            $this->forceFill(['read_at' => null])->save();
        }

        return $this;
    }

    /**
     * Scope the query to include only unread messages.
     *
     * @param $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeUnread($query)
    {
        return $query->whereNull('read_at');
    }

    /**
     * Retrieve the user instance.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->withTrashed();
    }

    /**
     * Retrieve the shop order instance.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order()
    {
        return $this->belongsTo(ShopOrder::class, 'shop_order_id')->withTrashed();
    }
}
