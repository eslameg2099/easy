<?php

namespace App\Http\Requests\Dashboard;

use App\Rules\ImageRule;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Astrotomic\Translatable\Validation\RuleFactory;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return RuleFactory::make([
        
            '%name%'  => ['required', 'string', 'max:255'],
            '%description%' => ['required', 'string'],
            'price' => ['required'],
            'has_discount' => ['nullable', 'boolean'],
            'offer_price' => Rule::requiredIf(function () {
                return $this->has_discount;
            }),
            'category_id' => [
                'required',
                Rule::exists('categories', 'id')->where(function (Builder $query) {
                    return $query
                        ->whereNull('categories.deleted_at')
                        ->whereNotExists(function (Builder $builder) {
                            $builder->from('categories', 'children')
                                ->whereColumn('categories.id', 'children.parent_id')
                                ->whereNull('children.deleted_at');
                        });
                }),
            ],
            'quantity' => ['required', 'numeric'],
            'colors' => ['nullable', 'array'],
            'colors.*.hex' => [
                'string',
                Rule::requiredIf(function () {
                    return is_array($this->colors);
                }),
            ],
            'colors.*.name' => [
                'string',
                Rule::requiredIf(function () {
                    return is_array($this->colors);
                }),
            ],
            'sizes' => ['nullable', 'array'],
            'sizes.*.size' => [
                'string',
                Rule::requiredIf(function () {
                    return is_array($this->sizes);
                }),
            ],


        ]);
       
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return trans('products.attributes');
    }
}
