<?php

namespace App\Models;

use App\Http\Filters\Filterable;
use App\Support\Traits\Selectable;
use App\Http\Filters\AddressFilter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Address extends Model
{
    use HasFactory;
    use Filterable;
    use Selectable;
    use SoftDeletes;

    /**
     * The query parameter's filter of the model.
     *
     * @var string
     */
    protected $filter = AddressFilter::class;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'user_id',
        'city_id',
        'address',
        'lat',
        'lng',
    ];

    /**
     * Retrieve the user instance.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    public function city()
    {
        return $this->belongsTo(City::class)->withTrashed();
    }

    public function cities()
    {
        return $this->belongsToMany(City::class);
    }
}
