<?php

namespace App\Models;

use Laraeast\LaravelSettings\Facades\Settings;
use Parental\HasChildren;
use App\Http\Filters\Filterable;
use App\Http\Filters\UserFilter;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use App\Models\Concerns\CanReview;
use App\Models\Contracts\Reviewer;
use App\Support\Traits\Selectable;
use App\Events\VerificationCreated;
use App\Models\Helpers\UserHelpers;
use App\Models\Concerns\HasMediaTrait;
use Spatie\Permission\Traits\HasRoles;
use App\Http\Resources\CustomerResource;
use App\Models\Presenters\UserPresenter;
use Illuminate\Notifications\Notifiable;
use Laracasts\Presenter\PresentableTrait;
use Lab404\Impersonate\Models\Impersonate;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use ChristianKuri\LaravelFavorite\Traits\Favoriteability;
use AhmedAliraqi\LaravelMediaUploader\Entities\Concerns\HasUploader;

class User extends Authenticatable implements HasMedia, Reviewer
{
    use HasFactory;
    use Notifiable;
    use UserHelpers;
    use HasChildren;
    use InteractsWithMedia;
    use HasMediaTrait;
    use HasApiTokens;
    use PresentableTrait;
    use Filterable;
    use Selectable;
    use HasUploader;
    use Impersonate;
    use HasRoles;
    use CanReview;
    use SoftDeletes;
    use Favoriteability;

    /**
     * The code of admin type.
     *
     * @var string
     */
    const ADMIN_TYPE = 'admin';

    /**
     * The code of supervisor type.
     *
     * @var string
     */
    const SUPERVISOR_TYPE = 'supervisor';

    /**
     * The code of customer type.
     *
     * @var string
     */
    const CUSTOMER_TYPE = 'customer';

    /**
     * The code of shop owner type.
     *
     * @var string
     */
    const SHOP_OWNER_TYPE = 'shop_owner';

    /**
     * The code of delegate type.
     *
     * @var string
     */
    const DELEGATE_TYPE = 'delegate';

    /**
     * The guard name of the user permissions.
     *
     * @var string
     */
    protected $guard_name = 'web';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'city_id',
        'remember_token',
        'tax',
    ];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = [
        'media',
        'city',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * @var array
     */
    protected $childTypes = [
        self::ADMIN_TYPE => Admin::class,
        self::SUPERVISOR_TYPE => Supervisor::class,
        self::SHOP_OWNER_TYPE => ShopOwner::class,
        self::DELEGATE_TYPE => Delegate::class,
        self::CUSTOMER_TYPE => Customer::class,
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The presenter class name.
     *
     * @var string
     */
    protected $presenter = UserPresenter::class;

    /**
     * The model filter name.
     *
     * @var string
     */
    protected $filter = UserFilter::class;

    /**
     * Get the dashboard profile link.
     *
     * @return string
     */
    public function dashboardProfile(): string
    {
        return '#';
    }

    /**
     * Get the number of models to return per page.
     *
     * @return int
     */
    public function getPerPage()
    {
        return request('perPage', parent::getPerPage());
    }

    /**
     * Get the resource for customer type.
     *
     * @return \App\Http\Resources\CustomerResource
     */
    public function getResource()
    {
        return new CustomerResource($this);
    }

    /**
     * Get the access token currently associated with the user. Create a new.
     *
     * @param string|null $device
     * @return string
     */
    public function createTokenForDevice($device = null)
    {
        $device = $device ?: 'Unknown Device';

        $this->tokens()->where('name', $device)->delete();

        return $this->createToken($device)->plainTextToken;
    }

    /**
     * Define the media collections.
     *
     * @return void
     */
    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('avatars')
            ->useFallbackUrl('https://www.gravatar.com/avatar/'.md5($this->email).'?d=mm')
            ->singleFile()
            ->registerMediaConversions(function () {
                $this->addMediaConversion('thumb')
                    ->width(70)
                    ->format('png');

                $this->addMediaConversion('small')
                    ->width(120)
                    ->format('png');

                $this->addMediaConversion('medium')
                    ->width(160)
                    ->format('png');

                $this->addMediaConversion('large')
                    ->width(320)
                    ->format('png');
            });
    }

    /**
     * The displayed image of the entity.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\UrlGenerator|string
     */
    public function image()
    {
        return $this->getAvatar();
    }

    /**
     * Determine whither the user can impersonate another user.
     *
     * @return bool
     */
    public function canImpersonate()
    {
        return $this->isAdmin();
    }

    /**
     * Determine whither the user can be impersonated by the admin.
     *
     * @return bool
     */
    public function canBeImpersonated()
    {
        return $this->isSupervisor();
    }

    /**
     * Get the user's city.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function city()
    {
        return $this->belongsTo(City::class)->withTrashed();
    }

    public function cities()
    {
        return $this->belongsToMany(City::class);
    }

    /**
     * Send the phone number verification code.
     *
     * @throws \Illuminate\Validation\ValidationException
     * @return void
     */
    public function sendVerificationCode()
    {
        if ($this->phone_verified_at) {
            throw ValidationException::withMessages([
                'phone' => [trans('verification.verified')],
            ]);
        }

        $verification = Verification::updateOrCreate([
            'user_id' => $this->id,
            'phone' => $this->phone,
        ], [
            'code' => rand(1111, 9999),
        ]);
        $details = [
            'title' => 'Easyget ACTIVE CODE',
            'body' => 'your code '.$verification->code ,
            'data'=> $this->name,
            'end'=> 'is approve',
            'user' => $this->name,
        ];
        \Mail::to($this->email)->send(new \App\Mail\email($details));
        event(new VerificationCreated($verification));
    }

    /**
     * Get all the user's addresses.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function addresses()
    {
        return $this->hasMany(Address::class, 'user_id');
    }

    /**
     * Get all the user's reports.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reports()
    {
        return $this->hasMany(Report::class, 'user_id');
    }

    /**
     * Check if a review for a specific model needs to be approved.
     *
     * @param mixed $model
     * @return bool
     */
    public function needsReviewApproval($model): bool
    {
        return false;
    }

    /**
     * Get the readable status for shops.
     *
     * @param $status
     * @return string
     */
    public function getReadableStatus($status)
    {
        return trans('orders.statuses.'.$status);
    }

    /**
     * Get the orders assigned to the delegate.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function delegateShopOrders()
    {
        return $this->hasMany(ShopOrder::class, 'delegate_id');
    }

    /**
     * Get the user phone with country key.
     *
     * @return string
     */
    public function getPhone()
    {
        return Settings::get('phone_prefix').$this->phone;
    }

    /**
     * Get the notification routing information for the SMS driver.
     *
     * @return string
     */
    public function routeNotificationForSMS()
    {
        return $this->getPhone();
    }


    public function notifications()
    {
        return $this->morphMany(Notification::class, 'notifiable')->orderBy('created_at', 'desc');
    }
    
}
