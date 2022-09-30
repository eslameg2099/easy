<?php

namespace App\Models;

use App\Casts\HtmlCast;
use App\Http\Filters\Filterable;
use App\Models\Concerns\Lockable;
use Spatie\MediaLibrary\HasMedia;
use App\Support\Traits\Selectable;
use App\Http\Filters\ProductFilter;
use App\Models\Concerns\Reviewable;
use App\Models\Concerns\HasMediaTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use ChristianKuri\LaravelFavorite\Traits\Favoriteable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use AhmedAliraqi\LaravelMediaUploader\Entities\Concerns\HasUploader;
use Astrotomic\Translatable\Translatable;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;

class Product extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;
    use HasUploader;
    use Filterable;
    use Selectable;
    use Lockable;
    use Reviewable;
    use HasMediaTrait;
    use SoftDeletes;
    use Favoriteable;
    use Translatable;


    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    public $translatedAttributes = ['name','description'];

    protected $with = ['translations','media'];

    /**
     * The query parameter's filter of the model.
     *
     * @var string
     */
    protected $filter = ProductFilter::class;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'shop_id',
        'category_id',
        'price',
        'offer_price',
        'has_discount',
        'quantity',
        'colors',
        'sizes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'has_discount' => 'boolean',
        'description' => HtmlCast::class,
        'colors' => 'array',
        'sizes' => 'array',
    ];

    /**
     * Define the media collections.
     *
     * @return void
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('default')->onlyKeepLatest(5);
    }

    /**
     * Qualify price field before saving.
     *
     * @param $value
     */
    public function setPriceAttribute($value)
    {
        $this->attributes['price'] = (float) $value;
    }

    /**
     * Qualify offer price field before saving.
     *
     * @param $value
     */
    public function setOfferPriceAttribute($value)
    {
        if (! $value) {
            return;
        }

        $this->attributes['offer_price'] = (float) $value;
    }

    /**
     * Retrieve the product's shop.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function shop()
    {
        return $this->belongsTo(Shop::class)->withTrashed();
    }

    /**
     * Get the product's category.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class)->withTrashed();
    }

    /**
     * Get the product's category and its parents.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class)->withCount('children');
    }

    /**
     * Get the product's price.
     *
     * @return float
     */
    public function getPrice()
    {
        if ($this->has_discount) {
            return $this->offer_price;
        }
        return $this->price;
    }

    /**
     * Scope the query to include only products has offers.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOffers(Builder $builder)
    {
        return $builder->where('has_discount', true);
    }

    /**
     * Scope the query to sort by offers.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOffersFirst(Builder $builder)
    {
        return $builder->orderByRaw(
            "CASE WHEN has_discount = ? THEN 0 ELSE has_discount != ? END",
            [1, 1]
        );
    }

    /**
     * Scope the query to include only products has has offers.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeMostSeller(Builder $builder)
    {
        // TODO: Handle query.
        return $builder;
    }

    /**
     * Handel an event after review.
     *
     * @param $review
     * @return void|mixed
     */
    protected function afterReview($review)
    {
        $rate = round($review->reviewable->reviews()->avg('rate'));

        $review->reviewable->forceFill(compact('rate'))->save();

        $rate = round($review->reviewable->refresh()->avg('rate'));

        $review->reviewable->shop->forceFill(compact('rate'))->save();
    }
}
