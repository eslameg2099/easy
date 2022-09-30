<?php

namespace App\Models;

use App\Events\BalanceCollected;
use App\Http\Filters\Filterable;
use App\Http\Filters\ShopFilter;
use Spatie\MediaLibrary\HasMedia;
use App\Support\Traits\Selectable;
use Illuminate\Support\Facades\DB;
use App\Models\Concerns\HasMediaTrait;
use App\Models\Relations\ShopRelations;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use AhmedAliraqi\LaravelMediaUploader\Entities\Concerns\HasUploader;

class Shop extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;
    use HasMediaTrait;
    use HasUploader;
    use Filterable;
    use Selectable;
    use ShopRelations;
    use SoftDeletes;

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = [
        'media',
        'category',
    ];

    /**
     * The query parameter's filter of the model.
     *
     * @var string
     */
    protected $filter = ShopFilter::class;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'name',
        'description',
        'lat',
        'lng',
        'category_id',
        'address',
        'free_shipping',
    ];

    /**
     * Define the media collections.
     *
     * @return void
     */
    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('logo')
            ->useFallbackUrl(url('/images/shop/logo.png'))
            ->singleFile();

        $this
            ->addMediaCollection('banner')
            ->useFallbackUrl(url('/images/shop/banner.png'))
            ->singleFile();
    }

    /**
     * The displayed image of the entity.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\UrlGenerator|string
     */
    public function image()
    {
        return $this->getFirstMediaUrl('logo');
    }

    /**
     * Retrieve the shop owner.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner()
    {
        return $this->belongsTo(ShopOwner::class, 'user_id')->withTrashed();
    }

    /**
     * Retrieve the shop owner.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id')->withTrashed();
    }

    /**
     * Get all the shop's orders.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders()
    {
        return $this->hasMany(ShopOrder::class, 'shop_id');
    }

    /**
     * Get all the shop's collects.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function collects()
    {
        return $this->hasMany(Collect::class, 'shop_id');
    }

    /**
     * Collect the due balance.
     *
     * @throws \Throwable
     * @return $this
     */
    public function collect()
    {
        $query = $this->orders()->where('status', Order::DELIVERED_STATUS)->whereNull('collected_at');

        DB::beginTransaction();
        try {
            $balance = (clone $query)->sum('total');

            if ($balance <= 0) {
                return $this;
            }

            $now = now();

            $collect = $this->collects()->create([
                'amount' => $balance,
                'date' => $now,
            ]);

            (clone $query)
                ->update([
                    'collected_at' => $now,
                ]);

            DB::commit();

            event(new BalanceCollected($collect));
        } catch (\Exception $exception) {
            DB::rollBack();
        }

        return $this;
    }
}
