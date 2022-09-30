<?php

namespace App\Models;

use Parental\HasParent;
use App\Http\Filters\ShopOwnerFilter;
use App\Http\Resources\ShopOwnerResource;
use App\Models\Relations\ShopOwnerRelations;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ShopOwner extends User
{
    use HasFactory;
    use HasParent;
    use ShopOwnerRelations;
    use SoftDeletes;

    /**
     * The model filter name.
     *
     * @var string
     */
    protected $filter = ShopOwnerFilter::class;

    /**
     * Get the class name for polymorphic relations.
     *
     * @return string
     */
    public function getMorphClass()
    {
        return User::class;
    }

    /**
     * Get the default foreign key name for the model.
     *
     * @return string
     */
    public function getForeignKey()
    {
        return 'user_id';
    }

    /**
     * @return \App\Http\Resources\ShopOwnerResource
     */
    public function getResource()
    {
        return new ShopOwnerResource($this->load('shop'));
    }

    /**
     * Get the dashboard profile link.
     *
     * @return string
     */
    public function dashboardProfile(): string
    {
        return route('dashboard.shop_owners.show', $this);
    }
}
