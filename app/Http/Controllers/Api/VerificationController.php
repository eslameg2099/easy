<?php

namespace App\Http\Controllers\Api;

use App\Models\Verification;
use Illuminate\Http\Request;
use App\Events\VerificationCreated;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Validation\ValidatesRequests;

class VerificationController extends Controller
{
    use ValidatesRequests;

    /**
     * Send or resend the verification code.
     *
     * @param \Illuminate\Http\Request $request
     * @throws \Illuminate\Validation\ValidationException
     * @return \Illuminate\Http\JsonResponse
     */
    public function send(Request $request)
    {
        $this->validate($request, [
            'phone' => ['required', 'unique:users,phone,'.auth()->id()],
        ], [], trans('verification.attributes'));

        $user = auth()->user();
        $user->phone = $request->phone;
        $user->phone_verified_at = null;
        $user->save();
        return $user->getResource();

    }

    /**
     * Verify the user's phone number.
     *
     * @param \Illuminate\Http\Request $request
     * @throws \Illuminate\Validation\ValidationException
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function verify(Request $request)
    {
       $user = auth()->user();
       $user->forceFill([
            'phone_verified_at' => now(),
        ])->save();
        return $user->getResource();
    }

    /**
     * Check if the password of the authenticated user is correct.
     *
     * @param \Illuminate\Http\Request $request
     * @throws \Illuminate\Validation\ValidationException
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function password(Request $request)
    {
        $request->validate([
            'password' => 'required',
        ], [], trans('auth.attributes'));

        if (! Hash::check($request->password, $request->user()->password)) {
            throw ValidationException::withMessages([
                'password' => [trans('auth.password')],
            ]);
        }

        return $request->user()->getResource();
    }
}
