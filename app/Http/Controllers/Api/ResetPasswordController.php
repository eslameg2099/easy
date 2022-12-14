<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Support\Str;
use App\Models\ResetPasswordCode;
use Illuminate\Auth\Events\Login;
use App\Models\ResetPasswordToken;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\Api\ResetPasswordRequest;
use App\Http\Requests\Api\ForgetPasswordRequest;
use App\Http\Requests\Api\ResetPasswordCodeRequest;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Notifications\Accounts\PasswordUpdatedNotification;
use App\Notifications\Accounts\SendForgetPasswordCodeNotification;

class ResetPasswordController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * Send the forget password code to the user.
     *
     * @param \App\Http\Requests\Api\ForgetPasswordRequest $request
     * @throws \Illuminate\Validation\ValidationException
     * @return \Illuminate\Http\JsonResponse
     */
    public function forget(ForgetPasswordRequest $request)
    {
        $user = User::where(function (Builder $query) use ($request) {
            $query->where('email', $request->username);
            $query->orWhere('phone', $request->username);
        })->first();

        if (! $user) {
            throw ValidationException::withMessages([
                'username' => [trans('auth.failed')],
            ]);
        }

        $resetPasswordCode = ResetPasswordCode::updateOrCreate([
            'username' => $request->username,
        ], [
            'username' => $request->username,
            'code' => rand(1111, 9999),
        ]);

        try {
            $user->notify(new SendForgetPasswordCodeNotification($resetPasswordCode->code));
        } catch (\Exception $exception) {
        }

        // TODO: remove this in production.
        //if (app()->environment('local')) {
        Storage::disk('public')->append(
            'verification.txt',
            "The reset password code for user {$request->username} is {$resetPasswordCode->code} generated at ".now()->toDateTimeString()."\n"
        );

        //}

        return response()->json([
            'message' => trans('auth.messages.forget-password-code-sent'),
            'links' => [
                'code' => [
                    'href' => route('api.password.code'),
                    'method' => 'POST',
                ],
            ],
        ]);
    }

    /**
     * Get the reset password token using verification code.
     *
     * @param \App\Http\Requests\Api\ResetPasswordCodeRequest $request
     * @throws \Illuminate\Validation\ValidationException
     * @return \Illuminate\Http\JsonResponse
     */
    public function code(ResetPasswordCodeRequest $request)
    {
        $resetPasswordCode = ResetPasswordCode::where('username', $request->username)
            ->where('code', $request->code)
            ->first();

        $user = User::where(function (Builder $query) use ($request) {
            $query->orWhere('phone', $request->username);
        })->first();

        if (! $resetPasswordCode || $resetPasswordCode->isExpired() || ! $user) {
            throw ValidationException::withMessages([
                'code' => [
                    trans('validation.exists', [
                        'attribute' => trans('auth.attributes.code'),
                    ]),
                ],
            ]);
        }

        $resetPasswordCode->delete();

        ResetPasswordToken::forceCreate([
            'user_id' => $user->id,
            'token' => $token = Str::random(80),
        ]);

        return response()->json([
            'reset_token' => $token,
            'links' => [
                'reset' => [
                    'href' => route('api.password.reset'),
                    'method' => 'POST',
                ],
            ],
        ]);
    }

    public function reset(ResetPasswordRequest $request)
    {  
        $user = User::where('phone',$request->phone)->first();
        $user->update([
            'password' => Hash::make($request->password),
        ]);
        return $user->getResource()->additional([
            'token' => $user->createTokenForDevice(
                $request->header('user-agent')
            ),
        ]);
    }
}
