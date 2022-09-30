<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Support\FirebaseToken;
use Illuminate\Auth\Events\Login;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Api\LoginRequest;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\Api\PasswordLessLoginRequest;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Pusher\PushNotifications\PushNotifications;

class LoginController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * @var \App\Support\FirebaseToken
     */
    private $firebaseToken;

    /**
     * LoginController constructor.
     *
     * @param \App\Support\FirebaseToken $firebaseToken
     */
    public function __construct(FirebaseToken $firebaseToken)
    {
        $this->firebaseToken = $firebaseToken;
    }

    /**
     * Handle a login request to the application.
     *
     * @param \App\Http\Requests\Api\LoginRequest $request
     * @throws \Illuminate\Validation\ValidationException
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function login(LoginRequest $request)
    {
        $user = User::where(function (Builder $query) use ($request) {
            $query->where('phone', $request->username);
        })
            ->when($request->type, function (Builder $builder) use ($request) {
                $builder->where('type', $request->type);
            })
            ->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'username' => [trans('auth.failed')],
            ]);
        }

        event(new Login('sanctum', $user, false));

        return $user->getResource()->additional([
            'token' => $user->createTokenForDevice(
                $request->header('user-agent')
            ),
        ]);
    }

    public function getPusherNotificationToken(Request $request)
    {
        $config = config('services.pusher');
        switch (auth()->user()->type)
        {
            case User::CUSTOMER_TYPE:
                $beamsClient = new PushNotifications([
                    'instanceId' => '9d89c0cb-dfb0-4b47-a841-1a73c16d9114',
                    'secretKey' => '370F68752EF850EF7512E9834812A5B417F84D97A9DEE3EF3F87740D310938AA',
                ]);
                break;
            case User::SHOP_OWNER_TYPE:
                $beamsClient = new PushNotifications([
                    'instanceId' => 'ac56fc82-5def-4cf9-bee2-d3ac911c4dcd',
                    'secretKey' => '4C36E47A6BEF555D0BE72CFB1B8219DFA16F741A789971E474F45A24EE15A63F',
                ]);
                break;
                case User::DELEGATE_TYPE:

                    $beamsClient = new PushNotifications([
                        'instanceId' => '827cd82c-b720-42f2-937c-960544531d28',
                        'secretKey' => 'DDB06C4D3014703EA556D270807144542190EF906065E5F9E07370D90651C678',
                    ]);
                    break;
        }
        $token = $beamsClient->generateToken((string)auth()->id());
        return response()->json($token);
    }
    /**
     * Handle a login request to the application using firebase.
     *
     * @param \App\Http\Requests\Api\PasswordLessLoginRequest $request
     * @throws \Illuminate\Auth\AuthenticationException
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function firebase(PasswordLessLoginRequest $request)
    {
        $verifier = $this->firebaseToken->accessToken($request->access_token);

        $phone = $verifier->getPhoneNumber();

        $email = $verifier->getEmail();
        $name = $verifier->getName();

        $firebaseId = $verifier->getFirebaseId();

        $userQuery = User::where(compact('phone'))
            ->orWhere(compact('email'))
            ->orWhere('firebase_id', $firebaseId);

        if ($userQuery->exists()) {
            $user = $userQuery->first();
        } else {
            $user = User::forceCreate([
                'firebase_id' => $firebaseId,
                'name' => $name ?: 'Anonymous User',
                'email' => $email,
                'phone' => $phone,
                'phone_verified_at' => $phone ? now() : null,
                'email_verified_at' => $email ? now() : null,
            ]);
        }

        event(new Login('sanctum', $user, false));

        return $user->getResource()->additional([
            'token' => $user->createTokenForDevice(
                $request->header('user-agent')
            ),
        ]);
    }
}
