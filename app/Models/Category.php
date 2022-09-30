<?php

namespace App\Models;

use App\Http\Filters\Filterable;
use Spatie\MediaLibrary\HasMedia;
use App\Support\Traits\Selectable;
use App\Models\Concerns\HasParents;
use App\Http\Filters\CategoryFilter;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Builder;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use AhmedAliraqi\LaravelMediaUploader\Entities\Concerns\HasUploader;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;

class Category extends Model implements TranslatableContract, HasMedia
{
    use HasFactory;
    use Translatable;
    use Filterable;
    use Selectable;
    use HasParents;
    use InteractsWithMedia;
    use HasUploader;
    use SoftDeletes;

    /**
     * The translated attributes that are mass assignable.
     *
     * @var array
     */
    public $translatedAttributes = ['name'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'parent_id',
        'display_in_home',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'parents' => 'array',
        'display_in_home' => 'boolean',
    ];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = [
        'translations',
    ];

    /**
     * The query parameter's filter of the model.
     *
     * @var string
     */
    protected $filter = CategoryFilter::class;

    /**
     * Get all children.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    /**
     * Get The parent of the category.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id')->withTrashed();
    }

    /**
     * Get all the category's products.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    /**
     * Get all the category's shops.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function shops()
    {
        return $this->hasMany(Shop::class, 'category_id');
    }

    /**
     * Get the category with its parents.
     *
     * @return \Illuminate\Support\Collection|\App\Models\Category[]
     */
    public function getWithParents()
    {
        $parents = Collection::make();

        $parent = $this;

        do {
            $parents->add($parent);
            $parent = $parent->parent;
        } while ($parent);

        return $parents->reverse()->values();
    }

    /**
     * Scope the query to include only parents categories.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeParentsOnly(Builder $builder)
    {
        return $builder->doesntHave('parent');
    }

    /**
     * Scope the query to include only parents categories.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeLeafsOnly(Builder $builder)
    {
        return $builder->doesntHave('children');
    }

    /**
     * The displayed image of the entity.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\UrlGenerator|string
     */
    public function image()
    {
        return $this->getFirstMediaUrl();
    }
}
