<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DelegateCollect extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'delegate_id',
        'amount',
        'date',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'date' => 'datetime',
    ];

    /**
     * Retrieve the delegate instance.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function delegate()
    {
        return $this->belongsTo(Delegate::class)->withTrashed();
    }
}
