<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'comment',
        'rate',
        'is_approved',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'is_approved' => 'boolean',
    ];

    /**
     * Retrieve the reviewer instance.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function reviewer()
    {
        return $this->belongsTo($this->getAuthModelName(), 'user_id');
    }

    /**
     * Retrieve the reviewable instance.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function reviewable()
    {
        return $this->morphTo('reviewable');
    }

    /**
     * Scope the query to include only approved reviews.
     *
     * @param $query
     * @return \App\Models\Review|\Illuminate\Database\Eloquent\Builder
     */
    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    /**
     * Mark the review as approved.
     *
     * @return $this
     */
    public function approve()
    {
        $this->forceFill([
            'is_approved' => true,
        ])->save();

        return $this;
    }

    /**
     * Mark the review as disapprove.
     *
     * @return $this
     */
    public function disapprove()
    {
        $this->forceFill([
            'is_approved' => false,
        ])->save();

        return $this;
    }

    /**
     * Get the user model that should be used when associating reviews with reviewers.
     *
     * @throws \Exception
     * @return \Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|mixed
     */
    protected function getAuthModelName()
    {
        if (config('reviewable.user_model')) {
            return config('reviewable.user_model');
        }

        if (config('auth.providers.users.model')) {
            return config('auth.providers.users.model');
        }

        throw new Exception('Could not determine the reviewer model name.');
    }
}
