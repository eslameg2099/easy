<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\Address
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $city_id
 * @property string|null $name
 * @property string|null $address
 * @property string $lat
 * @property string $lng
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\User|null $user
 * @method static \Database\Factories\AddressFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Address filter(?\App\Http\Filters\BaseFilters $filters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Address newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Address newQuery()
 * @method static \Illuminate\Database\Query\Builder|Address onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Address query()
 * @method static \Illuminate\Database\Eloquent\Builder|Address sortingByIds($ids)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereLat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereLng($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|Address withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Address withoutTrashed()
 */
	class Address extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Admin
 *
 * @property int $id
 * @property string $name
 * @property string|null $type
 * @property string|null $email
 * @property string|null $phone
 * @property string|null $firebase_id
 * @property string|null $phone_verified_at
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string|null $password
 * @property int|null $city_id
 * @property string|null $national_id
 * @property string|null $vehicle_type
 * @property string|null $vehicle_model
 * @property string|null $vehicle_number
 * @property int|null $is_available
 * @property int|null $is_approved
 * @property string|null $lat
 * @property string|null $lng
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Address[] $addresses
 * @property-read int|null $addresses_count
 * @property-read \App\Models\City|null $city
 * @property-read \Illuminate\Database\Eloquent\Collection|\ChristianKuri\LaravelFavorite\Models\Favorite[] $favorites
 * @property-read int|null $favorites_count
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection|\Spatie\MediaLibrary\MediaCollections\Models\Media[] $media
 * @property-read int|null $media_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Permission[] $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Report[] $reports
 * @property-read int|null $reports_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Role[] $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Sanctum\PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\AdminFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|User filter(?\App\Http\Filters\BaseFilters $filters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Admin newQuery()
 * @method static \Illuminate\Database\Query\Builder|Admin onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|User permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin query()
 * @method static \Illuminate\Database\Eloquent\Builder|User role($roles, $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder|User sortingByIds($ids)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereFirebaseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereIsApproved($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereIsAvailable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereLat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereLng($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereNationalId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin wherePhoneVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereVehicleModel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereVehicleNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereVehicleType($value)
 * @method static \Illuminate\Database\Query\Builder|Admin withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Admin withoutTrashed()
 */
	class Admin extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Cart
 *
 * @property int $id
 * @property string $identifier
 * @property int|null $user_id
 * @property string $sub_total
 * @property string $shipping_cost
 * @property string $discount
 * @property int|null $payment_method
 * @property string|null $total
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\CartItem[] $items
 * @property-read int|null $items_count
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|Cart newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Cart newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Cart query()
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereIdentifier($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart wherePaymentMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereShippingCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereSubTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereUserId($value)
 */
	class Cart extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\CartItem
 *
 * @property int $id
 * @property int $cart_id
 * @property int $product_id
 * @property string $price
 * @property int $quantity
 * @property int $updated
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Cart $cart
 * @property-read \App\Models\Product $product
 * @method static \Illuminate\Database\Eloquent\Builder|CartItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CartItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CartItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|CartItem whereCartId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CartItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CartItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CartItem wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CartItem whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CartItem whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CartItem whereUpdated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CartItem whereUpdatedAt($value)
 */
	class CartItem extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Category
 *
 * @property int $id
 * @property int|null $parent_id
 * @property array|null $parents
 * @property bool|null $display_in_home
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|Category[] $children
 * @property-read int|null $children_count
 * @property-read \Illuminate\Database\Eloquent\Collection|Category[] $childrenRelation
 * @property-read int|null $children_relation_count
 * @property-read string $full_name
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection|\Spatie\MediaLibrary\MediaCollections\Models\Media[] $media
 * @property-read int|null $media_count
 * @property-read Category|null $parent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Product[] $products
 * @property-read int|null $products_count
 * @property-read \App\Models\Translations\CategoryTranslation|null $translation
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Translations\CategoryTranslation[] $translations
 * @property-read int|null $translations_count
 * @method static \Database\Factories\CategoryFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Category filter(?\App\Http\Filters\BaseFilters $filters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Category leafsOnly()
 * @method static \Illuminate\Database\Eloquent\Builder|Category listsTranslations(string $translationField)
 * @method static \Illuminate\Database\Eloquent\Builder|Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category notTranslatedIn(?string $locale = null)
 * @method static \Illuminate\Database\Query\Builder|Category onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Category orWhereTranslation(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Category orWhereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Category orderByTranslation(string $translationField, string $sortMethod = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|Category parentsOnly()
 * @method static \Illuminate\Database\Eloquent\Builder|Category query()
 * @method static \Illuminate\Database\Eloquent\Builder|Category sortingByIds($ids)
 * @method static \Illuminate\Database\Eloquent\Builder|Category translated()
 * @method static \Illuminate\Database\Eloquent\Builder|Category translatedIn(?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereDisplayInHome($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereParents($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereTranslation(string $translationField, $value, ?string $locale = null, string $method = 'whereHas', string $operator = '=')
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category withTranslation()
 * @method static \Illuminate\Database\Query\Builder|Category withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Category withoutTrashed()
 */
	class Category extends \Eloquent implements \Astrotomic\Translatable\Contracts\Translatable, \Spatie\MediaLibrary\HasMedia {}
}

namespace App\Models{
/**
 * App\Models\City
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Customer[] $customers
 * @property-read int|null $customers_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Delegate[] $delegates
 * @property-read int|null $delegates_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ShopOwner[] $shopOwners
 * @property-read int|null $shop_owners_count
 * @property-read \App\Models\Translations\CityTranslation|null $translation
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Translations\CityTranslation[] $translations
 * @property-read int|null $translations_count
 * @method static \Database\Factories\CityFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|City filter(?\App\Http\Filters\BaseFilters $filters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|City listsTranslations(string $translationField)
 * @method static \Illuminate\Database\Eloquent\Builder|City newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|City newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|City notTranslatedIn(?string $locale = null)
 * @method static \Illuminate\Database\Query\Builder|City onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|City orWhereTranslation(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|City orWhereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|City orderByTranslation(string $translationField, string $sortMethod = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|City query()
 * @method static \Illuminate\Database\Eloquent\Builder|City sortingByIds($ids)
 * @method static \Illuminate\Database\Eloquent\Builder|City translated()
 * @method static \Illuminate\Database\Eloquent\Builder|City translatedIn(?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereTranslation(string $translationField, $value, ?string $locale = null, string $method = 'whereHas', string $operator = '=')
 * @method static \Illuminate\Database\Eloquent\Builder|City whereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City withTranslation()
 * @method static \Illuminate\Database\Query\Builder|City withTrashed()
 * @method static \Illuminate\Database\Query\Builder|City withoutTrashed()
 */
	class City extends \Eloquent implements \Astrotomic\Translatable\Contracts\Translatable {}
}

namespace App\Models{
/**
 * App\Models\Collect
 *
 * @property int $id
 * @property int $shop_id
 * @property string $amount
 * @property \Illuminate\Support\Carbon $date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Shop $shop
 * @method static \Illuminate\Database\Eloquent\Builder|Collect newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Collect newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Collect query()
 * @method static \Illuminate\Database\Eloquent\Builder|Collect whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Collect whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Collect whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Collect whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Collect whereShopId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Collect whereUpdatedAt($value)
 */
	class Collect extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Customer
 *
 * @property int $id
 * @property string $name
 * @property string|null $type
 * @property string|null $email
 * @property string|null $phone
 * @property string|null $firebase_id
 * @property string|null $phone_verified_at
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string|null $password
 * @property int|null $city_id
 * @property string|null $national_id
 * @property string|null $vehicle_type
 * @property string|null $vehicle_model
 * @property string|null $vehicle_number
 * @property int|null $is_available
 * @property int|null $is_approved
 * @property string|null $lat
 * @property string|null $lng
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Address[] $addresses
 * @property-read int|null $addresses_count
 * @property-read \App\Models\City|null $city
 * @property-read \Illuminate\Database\Eloquent\Collection|\ChristianKuri\LaravelFavorite\Models\Favorite[] $favorites
 * @property-read int|null $favorites_count
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection|\Spatie\MediaLibrary\MediaCollections\Models\Media[] $media
 * @property-read int|null $media_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Order[] $orders
 * @property-read int|null $orders_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Permission[] $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Report[] $reports
 * @property-read int|null $reports_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Role[] $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Sanctum\PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\CustomerFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|User filter(?\App\Http\Filters\BaseFilters $filters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Customer newQuery()
 * @method static \Illuminate\Database\Query\Builder|Customer onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|User permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer query()
 * @method static \Illuminate\Database\Eloquent\Builder|User role($roles, $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder|User sortingByIds($ids)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereFirebaseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereIsApproved($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereIsAvailable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereLat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereLng($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereNationalId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer wherePhoneVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereVehicleModel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereVehicleNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereVehicleType($value)
 * @method static \Illuminate\Database\Query\Builder|Customer withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Customer withoutTrashed()
 */
	class Customer extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Delegate
 *
 * @property int $id
 * @property string $name
 * @property string|null $type
 * @property string|null $email
 * @property string|null $phone
 * @property string|null $firebase_id
 * @property string|null $phone_verified_at
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string|null $password
 * @property int|null $city_id
 * @property string|null $national_id
 * @property string|null $vehicle_type
 * @property string|null $vehicle_model
 * @property string|null $vehicle_number
 * @property int|null $is_available
 * @property int|null $is_approved
 * @property string|null $lat
 * @property string|null $lng
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Address[] $addresses
 * @property-read int|null $addresses_count
 * @property-read \App\Models\City|null $city
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\DelegateCollect[] $collects
 * @property-read int|null $collects_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\ChristianKuri\LaravelFavorite\Models\Favorite[] $favorites
 * @property-read int|null $favorites_count
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection|\Spatie\MediaLibrary\MediaCollections\Models\Media[] $media
 * @property-read int|null $media_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Permission[] $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Report[] $reports
 * @property-read int|null $reports_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Role[] $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ShopOrder[] $shopOrders
 * @property-read int|null $shop_orders_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Sanctum\PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\DelegateFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|User filter(?\App\Http\Filters\BaseFilters $filters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Delegate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Delegate newQuery()
 * @method static \Illuminate\Database\Query\Builder|Delegate onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|User permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|Delegate query()
 * @method static \Illuminate\Database\Eloquent\Builder|User role($roles, $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder|User sortingByIds($ids)
 * @method static \Illuminate\Database\Eloquent\Builder|Delegate whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Delegate whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Delegate whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Delegate whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Delegate whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Delegate whereFirebaseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Delegate whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Delegate whereIsApproved($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Delegate whereIsAvailable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Delegate whereLat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Delegate whereLng($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Delegate whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Delegate whereNationalId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Delegate wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Delegate wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Delegate wherePhoneVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Delegate whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Delegate whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Delegate whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Delegate whereVehicleModel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Delegate whereVehicleNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Delegate whereVehicleType($value)
 * @method static \Illuminate\Database\Query\Builder|Delegate withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Delegate withoutTrashed()
 */
	class Delegate extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\DelegateCollect
 *
 * @property int $id
 * @property int $delegate_id
 * @property string $amount
 * @property \Illuminate\Support\Carbon $date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Delegate $delegate
 * @method static \Illuminate\Database\Eloquent\Builder|DelegateCollect newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DelegateCollect newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DelegateCollect query()
 * @method static \Illuminate\Database\Eloquent\Builder|DelegateCollect whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DelegateCollect whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DelegateCollect whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DelegateCollect whereDelegateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DelegateCollect whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DelegateCollect whereUpdatedAt($value)
 */
	class DelegateCollect extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Feedback
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $phone
 * @property string|null $email
 * @property string|null $message
 * @property \Illuminate\Support\Carbon|null $read_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Database\Factories\FeedbackFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Feedback filter(?\App\Http\Filters\BaseFilters $filters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Feedback newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Feedback newQuery()
 * @method static \Illuminate\Database\Query\Builder|Feedback onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Feedback query()
 * @method static \Illuminate\Database\Eloquent\Builder|Feedback sortingByIds($ids)
 * @method static \Illuminate\Database\Eloquent\Builder|Feedback unread()
 * @method static \Illuminate\Database\Eloquent\Builder|Feedback whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feedback whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feedback whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feedback whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feedback whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feedback whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feedback wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feedback whereReadAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feedback whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Feedback withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Feedback withoutTrashed()
 */
	class Feedback extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Order
 *
 * @method OrderPresenter present()
 * @property int $id
 * @property int $user_id
 * @property int $address_id
 * @property int $status
 * @property string $sub_total
 * @property string $shipping_cost
 * @property string $discount
 * @property int $payment_method
 * @property string|null $total
 * @property int|null $paid
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Address $address
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ShopOrder[] $shopOrders
 * @property-read int|null $shop_orders_count
 * @property-read \App\Models\Customer $user
 * @method static \Database\Factories\OrderFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Order filter(?\App\Http\Filters\BaseFilters $filters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Order newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Order newQuery()
 * @method static \Illuminate\Database\Query\Builder|Order onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Order query()
 * @method static \Illuminate\Database\Eloquent\Builder|Order sortingByIds($ids)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereAddressId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order wherePaid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order wherePaymentMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereShippingCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereSubTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|Order withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Order withoutTrashed()
 */
	class Order extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Product
 *
 * @property int $id
 * @property string $name
 * @property mixed $description
 * @property int $shop_id
 * @property int $category_id
 * @property string $price
 * @property string|null $offer_price
 * @property bool|null $has_discount
 * @property int $quantity
 * @property float|null $rate
 * @property array|null $colors
 * @property array|null $sizes
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $locked_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Category[] $categories
 * @property-read int|null $categories_count
 * @property-read \App\Models\Category $category
 * @property-read \Illuminate\Database\Eloquent\Collection|\ChristianKuri\LaravelFavorite\Models\Favorite[] $favorites
 * @property-read int $favorites_count
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection|\Spatie\MediaLibrary\MediaCollections\Models\Media[] $media
 * @property-read int|null $media_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Review[] $reviews
 * @property-read int|null $reviews_count
 * @property-read \App\Models\Shop $shop
 * @method static \Database\Factories\ProductFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Product filter(?\App\Http\Filters\BaseFilters $filters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Product locked()
 * @method static \Illuminate\Database\Eloquent\Builder|Product mostSeller()
 * @method static \Illuminate\Database\Eloquent\Builder|Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product offers()
 * @method static \Illuminate\Database\Eloquent\Builder|Product offersFirst()
 * @method static \Illuminate\Database\Query\Builder|Product onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Product query()
 * @method static \Illuminate\Database\Eloquent\Builder|Product sortingByIds($ids)
 * @method static \Illuminate\Database\Eloquent\Builder|Product unlocked()
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereColors($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereHasDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereLockedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereOfferPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereShopId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereSizes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Product withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Product withoutTrashed()
 */
	class Product extends \Eloquent implements \Spatie\MediaLibrary\HasMedia {}
}

namespace App\Models{
/**
 * App\Models\Report
 *
 * @property int $id
 * @property int $user_id
 * @property int $shop_order_id
 * @property string|null $message
 * @property \Illuminate\Support\Carbon|null $read_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \App\Models\ShopOrder $order
 * @method static \Database\Factories\ReportFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Report filter(?\App\Http\Filters\BaseFilters $filters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Report newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Report newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Report query()
 * @method static \Illuminate\Database\Eloquent\Builder|Report sortingByIds($ids)
 * @method static \Illuminate\Database\Eloquent\Builder|Report unread()
 * @method static \Illuminate\Database\Eloquent\Builder|Report whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Report whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Report whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Report whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Report whereReadAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Report whereShopOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Report whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Report whereUserId($value)
 */
	class Report extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ResetPasswordCode
 *
 * @property int $id
 * @property string $username
 * @property string $code
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ResetPasswordCode newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ResetPasswordCode newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ResetPasswordCode query()
 * @method static \Illuminate\Database\Eloquent\Builder|ResetPasswordCode whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResetPasswordCode whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResetPasswordCode whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResetPasswordCode whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResetPasswordCode whereUsername($value)
 */
	class ResetPasswordCode extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ResetPasswordToken
 *
 * @property int $id
 * @property int $user_id
 * @property string $token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property string|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|ResetPasswordToken newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ResetPasswordToken newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ResetPasswordToken query()
 * @method static \Illuminate\Database\Eloquent\Builder|ResetPasswordToken whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResetPasswordToken whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResetPasswordToken whereToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResetPasswordToken whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResetPasswordToken whereUserId($value)
 */
	class ResetPasswordToken extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Review
 *
 * @property int $id
 * @property int $user_id
 * @property string $reviewable_type
 * @property int $reviewable_id
 * @property string $comment
 * @property float $rate
 * @property bool $is_approved
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $reviewable
 * @property-read \App\Models\User $reviewer
 * @method static \Illuminate\Database\Eloquent\Builder|Review approved()
 * @method static \Illuminate\Database\Eloquent\Builder|Review newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Review newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Review query()
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereIsApproved($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereReviewableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereReviewableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereUserId($value)
 */
	class Review extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Setting
 *
 * @property int $id
 * @property string $key
 * @property string|null $locale
 * @property string|null $value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection|\Spatie\MediaLibrary\MediaCollections\Models\Media[] $media
 * @property-read int|null $media_count
 * @method static \Illuminate\Database\Eloquent\Builder|Setting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Setting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Setting query()
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereLocale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereValue($value)
 */
	class Setting extends \Eloquent implements \Spatie\MediaLibrary\HasMedia {}
}

namespace App\Models{
/**
 * App\Models\Shop
 *
 * @property int $id
 * @property int $user_id
 * @property string|null $name
 * @property string|null $description
 * @property float|null $rate
 * @property string|null $address
 * @property string|null $lat
 * @property string|null $lng
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Collect[] $collects
 * @property-read int|null $collects_count
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection|\Spatie\MediaLibrary\MediaCollections\Models\Media[] $media
 * @property-read int|null $media_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ShopOrder[] $orders
 * @property-read int|null $orders_count
 * @property-read \App\Models\ShopOwner $owner
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Product[] $products
 * @property-read int|null $products_count
 * @method static \Database\Factories\ShopFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Shop filter(?\App\Http\Filters\BaseFilters $filters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Shop newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Shop newQuery()
 * @method static \Illuminate\Database\Query\Builder|Shop onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Shop query()
 * @method static \Illuminate\Database\Eloquent\Builder|Shop sortingByIds($ids)
 * @method static \Illuminate\Database\Eloquent\Builder|Shop whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shop whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shop whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shop whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shop whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shop whereLat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shop whereLng($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shop whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shop whereRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shop whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shop whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|Shop withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Shop withoutTrashed()
 */
	class Shop extends \Eloquent implements \Spatie\MediaLibrary\HasMedia {}
}

namespace App\Models{
/**
 * App\Models\ShopOrder
 *
 * @method OrderPresenter present()
 * @property int $id
 * @property int $order_id
 * @property int $shop_id
 * @property int|null $delegate_id
 * @property int $status
 * @property string $sub_total
 * @property string $shipping_cost
 * @property string $discount
 * @property string|null $total
 * @property \Illuminate\Support\Carbon|null $collected_at
 * @property \Illuminate\Support\Carbon|null $delegate_collected_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Delegate|null $delegate
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ShopOrderProduct[] $items
 * @property-read int|null $items_count
 * @property-read \App\Models\Order $order
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Report[] $reports
 * @property-read int|null $reports_count
 * @property-read \App\Models\Shop $shop
 * @method static \Illuminate\Database\Eloquent\Builder|ShopOrder filter(?\App\Http\Filters\BaseFilters $filters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopOrder newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ShopOrder newQuery()
 * @method static \Illuminate\Database\Query\Builder|ShopOrder onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ShopOrder query()
 * @method static \Illuminate\Database\Eloquent\Builder|ShopOrder whereCollectedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopOrder whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopOrder whereDelegateCollectedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopOrder whereDelegateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopOrder whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopOrder whereDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopOrder whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopOrder whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopOrder whereShippingCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopOrder whereShopId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopOrder whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopOrder whereSubTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopOrder whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopOrder whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|ShopOrder withTrashed()
 * @method static \Illuminate\Database\Query\Builder|ShopOrder withoutTrashed()
 */
	class ShopOrder extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ShopOrderProduct
 *
 * @property int $id
 * @property int $shop_order_id
 * @property int $product_id
 * @property int $quantity
 * @property array|null $color
 * @property array|null $size
 * @property string $price
 * @property string|null $total
 * @property-read \App\Models\Product $product
 * @property-read \App\Models\ShopOrder $shopOrder
 * @method static \Illuminate\Database\Eloquent\Builder|ShopOrderProduct filter(?\App\Http\Filters\BaseFilters $filters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopOrderProduct newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ShopOrderProduct newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ShopOrderProduct query()
 * @method static \Illuminate\Database\Eloquent\Builder|ShopOrderProduct sortingByIds($ids)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopOrderProduct whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopOrderProduct whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopOrderProduct wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopOrderProduct whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopOrderProduct whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopOrderProduct whereShopOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopOrderProduct whereSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopOrderProduct whereTotal($value)
 */
	class ShopOrderProduct extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ShopOwner
 *
 * @property int $id
 * @property string $name
 * @property string|null $type
 * @property string|null $email
 * @property string|null $phone
 * @property string|null $firebase_id
 * @property string|null $phone_verified_at
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string|null $password
 * @property int|null $city_id
 * @property string|null $national_id
 * @property string|null $vehicle_type
 * @property string|null $vehicle_model
 * @property string|null $vehicle_number
 * @property int|null $is_available
 * @property int|null $is_approved
 * @property string|null $lat
 * @property string|null $lng
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Address[] $addresses
 * @property-read int|null $addresses_count
 * @property-read \App\Models\City|null $city
 * @property-read \Illuminate\Database\Eloquent\Collection|\ChristianKuri\LaravelFavorite\Models\Favorite[] $favorites
 * @property-read int|null $favorites_count
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection|\Spatie\MediaLibrary\MediaCollections\Models\Media[] $media
 * @property-read int|null $media_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Permission[] $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Product[] $products
 * @property-read int|null $products_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Report[] $reports
 * @property-read int|null $reports_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Role[] $roles
 * @property-read int|null $roles_count
 * @property-read \App\Models\Shop|null $shop
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Shop[] $shops
 * @property-read int|null $shops_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Sanctum\PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\ShopOwnerFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|User filter(?\App\Http\Filters\BaseFilters $filters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopOwner newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ShopOwner newQuery()
 * @method static \Illuminate\Database\Query\Builder|ShopOwner onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|User permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopOwner query()
 * @method static \Illuminate\Database\Eloquent\Builder|User role($roles, $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder|User sortingByIds($ids)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopOwner whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopOwner whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopOwner whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopOwner whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopOwner whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopOwner whereFirebaseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopOwner whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopOwner whereIsApproved($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopOwner whereIsAvailable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopOwner whereLat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopOwner whereLng($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopOwner whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopOwner whereNationalId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopOwner wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopOwner wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopOwner wherePhoneVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopOwner whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopOwner whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopOwner whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopOwner whereVehicleModel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopOwner whereVehicleNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopOwner whereVehicleType($value)
 * @method static \Illuminate\Database\Query\Builder|ShopOwner withTrashed()
 * @method static \Illuminate\Database\Query\Builder|ShopOwner withoutTrashed()
 */
	class ShopOwner extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Supervisor
 *
 * @property int $id
 * @property string $name
 * @property string|null $type
 * @property string|null $email
 * @property string|null $phone
 * @property string|null $firebase_id
 * @property string|null $phone_verified_at
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string|null $password
 * @property int|null $city_id
 * @property string|null $national_id
 * @property string|null $vehicle_type
 * @property string|null $vehicle_model
 * @property string|null $vehicle_number
 * @property int|null $is_available
 * @property int|null $is_approved
 * @property string|null $lat
 * @property string|null $lng
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Address[] $addresses
 * @property-read int|null $addresses_count
 * @property-read \App\Models\City|null $city
 * @property-read \Illuminate\Database\Eloquent\Collection|\ChristianKuri\LaravelFavorite\Models\Favorite[] $favorites
 * @property-read int|null $favorites_count
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection|\Spatie\MediaLibrary\MediaCollections\Models\Media[] $media
 * @property-read int|null $media_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Permission[] $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Report[] $reports
 * @property-read int|null $reports_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Role[] $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Sanctum\PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\SupervisorFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|User filter(?\App\Http\Filters\BaseFilters $filters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Supervisor newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Supervisor newQuery()
 * @method static \Illuminate\Database\Query\Builder|Supervisor onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|User permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|Supervisor query()
 * @method static \Illuminate\Database\Eloquent\Builder|User role($roles, $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder|User sortingByIds($ids)
 * @method static \Illuminate\Database\Eloquent\Builder|Supervisor whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supervisor whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supervisor whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supervisor whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supervisor whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supervisor whereFirebaseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supervisor whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supervisor whereIsApproved($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supervisor whereIsAvailable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supervisor whereLat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supervisor whereLng($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supervisor whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supervisor whereNationalId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supervisor wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supervisor wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supervisor wherePhoneVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supervisor whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supervisor whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supervisor whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supervisor whereVehicleModel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supervisor whereVehicleNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supervisor whereVehicleType($value)
 * @method static \Illuminate\Database\Query\Builder|Supervisor withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Supervisor withoutTrashed()
 */
	class Supervisor extends \Eloquent {}
}

namespace App\Models\Translations{
/**
 * App\Models\Translations\CategoryTranslation
 *
 * @property int $id
 * @property int $category_id
 * @property string|null $name
 * @property string $locale
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryTranslation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryTranslation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryTranslation query()
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryTranslation whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryTranslation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryTranslation whereLocale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryTranslation whereName($value)
 */
	class CategoryTranslation extends \Eloquent {}
}

namespace App\Models\Translations{
/**
 * App\Models\Translations\CityTranslation
 *
 * @property int $id
 * @property int $city_id
 * @property string|null $name
 * @property string $locale
 * @method static \Illuminate\Database\Eloquent\Builder|CityTranslation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CityTranslation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CityTranslation query()
 * @method static \Illuminate\Database\Eloquent\Builder|CityTranslation whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CityTranslation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CityTranslation whereLocale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CityTranslation whereName($value)
 */
	class CityTranslation extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string|null $type
 * @property string|null $email
 * @property string|null $phone
 * @property string|null $firebase_id
 * @property string|null $phone_verified_at
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string|null $password
 * @property int|null $city_id
 * @property string|null $national_id
 * @property string|null $vehicle_type
 * @property string|null $vehicle_model
 * @property string|null $vehicle_number
 * @property int|null $is_available
 * @property int|null $is_approved
 * @property string|null $lat
 * @property string|null $lng
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Address[] $addresses
 * @property-read int|null $addresses_count
 * @property-read \App\Models\City|null $city
 * @property-read \Illuminate\Database\Eloquent\Collection|\ChristianKuri\LaravelFavorite\Models\Favorite[] $favorites
 * @property-read int|null $favorites_count
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection|\Spatie\MediaLibrary\MediaCollections\Models\Media[] $media
 * @property-read int|null $media_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Permission[] $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Report[] $reports
 * @property-read int|null $reports_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Role[] $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Sanctum\PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|User filter(?\App\Http\Filters\BaseFilters $filters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Query\Builder|User onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|User permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User role($roles, $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder|User sortingByIds($ids)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereFirebaseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereIsApproved($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereIsAvailable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLng($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereNationalId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePhoneVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereVehicleModel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereVehicleNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereVehicleType($value)
 * @method static \Illuminate\Database\Query\Builder|User withTrashed()
 * @method static \Illuminate\Database\Query\Builder|User withoutTrashed()
 */
	class User extends \Eloquent implements \Spatie\MediaLibrary\HasMedia, \App\Models\Contracts\Reviewer {}
}

namespace App\Models{
/**
 * App\Models\Verification
 *
 * @property \Carbon\Carbon $created_at
 * @property int $id
 * @property int $user_id
 * @property string $phone
 * @property string $code
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Verification newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Verification newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Verification query()
 * @method static \Illuminate\Database\Eloquent\Builder|Verification whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Verification whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Verification whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Verification wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Verification whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Verification whereUserId($value)
 */
	class Verification extends \Eloquent {}
}

