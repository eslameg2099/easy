<?php

namespace App\Models\Contracts;

interface Reviewer
{
    /**
     * Check if a review for a specific model needs to be approved.
     *
     * @param mixed $model
     * @return bool
     */
    public function needsReviewApproval($model): bool;
}
