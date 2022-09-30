<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Customer;
use App\Models\Delegate;
use App\Models\ShopOwner;
use App\Models\Verification;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use App\Events\VerificationCreated;
use Illuminate\Auth\Events\Registered;
use App\Http\Requests\Api\RegisterRequest;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Laraeast\LaravelSettings\Facades\Settings;

class RegisterController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * Handle a login request to the application.
     *
     * @param \App\Http\Requests\Api\RegisterRequest $request
     * @throws \Illuminate\Validation\ValidationException
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function register(RegisterRequest $request)
    {
        switch ($request->type) {
            case User::SHOP_OWNER_TYPE:
                $user = $this->createShopOwner($request);
                break;
            case User::DELEGATE_TYPE:
                $user = $this->createDelegate($request);
                break;
            case User::CUSTOMER_TYPE:
            default:
                $user = $this->createCustomer($request);
                break;
        }

        $user->uploadFile('avatar', 'avatars');

        event(new Registered($user));

        $this->sendVerificationCode($user);

        return $user->getResource()->additional([
            'token' => $user->createTokenForDevice(
                $request->header('user-agent')
            ),
            'message' => trans('verification.sent'),
        ]);
    }

    /**
     * Create new customer to register to the application.
     *
     * @param \App\Http\Requests\Api\RegisterRequest $request
     * @return \App\Models\Customer
     */
    public function createCustomer(RegisterRequest $request)
    {
        $customer = new Customer();

        $customer
            ->forceFill($request->only('phone'))
            ->fill($request->allWithHashedPassword())
            ->save();

        return $customer;
    }

    /**
     * Create new delegate to register to the application.
     *
     * @param \App\Http\Requests\Api\RegisterRequest $request
     * @return \App\Models\Delegate
     */
    public function createDelegate(RegisterRequest $request)
    {
        DB::beginTransaction();
        $delegate = new Delegate();

        $delegate
            ->forceFill($request->only('phone'))
            ->fill($request->allWithHashedPassword())
            ->save();

        $delegate->uploadFile('national_front_image', 'national_front_image');
        $delegate->uploadFile('national_back_image', 'national_back_image');
        $delegate->uploadFile('vehicle_image', 'vehicle_image');

        DB::commit();

        return $delegate;
    }

    /**
     * Create new shop owner to register to the application.
     *
     * @param \App\Http\Requests\Api\RegisterRequest $request
     * @return \App\Models\ShopOwner
     */
    public function createShopOwner(RegisterRequest $request)
    {
             DB::beginTransaction();
             $defalut_tax =  Settings::get('tax');

             $shopOwner = new ShopOwner();
             $shopOwner
            ->forceFill($request->only('phone'))
            ->fill($request->allWithHashedPassword())
            ->save();
             $shopOwner->tax=$defalut_tax;
             $shopOwner->save();

        /** @var \App\Models\Shop $shop */
        $shop = $shopOwner->shops()->create($request->prefixedWith('shop_'));

        $shop->uploadFile('shop_logo', 'logo');
        $shop->address=$request->address;
        $shop->uploadFile('shop_banner', 'banner');
        $shop->save();

        DB::commit();

        return $shopOwner->load('shop');
    }

    /**
     * Send the phone number verification code.
     *
     * @param \App\Models\User $user
     * @throws \Illuminate\Validation\ValidationException
     * @return mixed
     */
    protected function sendVerificationCode(User $user)
    {
        return $user->sendVerificationCode();
    }
}
