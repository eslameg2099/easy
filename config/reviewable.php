<?php

return [
    /*
     * The review class that should be used to store and retrieve
     * the reviews.
     */
    'review_class' => \App\Models\Review::class,

    /*
     * The user model that should be used when associating reviews with
     * reviewers. If null, the default user provider from your
     * Laravel authentication configuration will be used.
     */
    'user_model' => null,
];
