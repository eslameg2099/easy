<?php

return [
    'failed' => 'These credentials do not match our records.',
    'password' => 'The password you entered is incorrect.',
    'already-verified' => 'The phone number is already verified.',
    'throttle' => 'Too many login attempts. Please try again in :seconds seconds.',
    'attributes' => [
        'code' => 'Verification Code',
        'token' => 'Verification Token',
        'email' => 'Email',
        'phone' => 'phone',
        'username' => 'Email Or Phone',
        'password' => 'Password',
    ],
    'messages' => [
        'forget-password-code-sent' => 'The reset password code was sent to your E-mail address.',
    ],
    'emails' => [
        'forget-password' => [
            'subject' => 'Reset Password',
            'greeting' => 'Dear :user',
            'line' => 'Your password recovery code is :code valid for :minutes minutes',
            'footer' => 'Thank you for using our application!',
            'salutation' => 'Regards, :app',
        ],
        'reset-password' => [
            'subject' => 'Reset Password',
            'greeting' => 'Dear :user',
            'line' => 'Your password has been reset successfully.',
            'footer' => 'Thank you for using our application!',
            'salutation' => 'Regards, :app',
        ],
    ],
];
