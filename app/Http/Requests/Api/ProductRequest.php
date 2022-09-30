<?php

namespace App\Http\Requests\Api;

use App\Models\Product;
use App\Rules\ImageRule;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Gate;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Astrotomic\Translatable\Validation\RuleFactory;

/**
 * @method \App\Models\ShopOwner user($guard = null)
 */
class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->isMethod('POST')) {
            return Gate::allows('create', Product::class);
        }

        return Gate::allows('update', $this->route('product'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return $this->isMethod('POST')
            ? $this->createRules()
            : $this->updateRules();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function createRules()
    {
        return RuleFactory::make([
            'name:ar' => ['required', 'string', 'max:255'],
            'name:en' => ['nullable','string', 'max:255'],
            'description:ar' => ['required', 'string', 'max:255'],
            'description:en' => ['nullable','string', 'max:255'],
            'price' => ['required', 'numeric'],
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
            'images' => ['required', 'array'],
            'images.*' => ['required', new ImageRule()],
        ]);

       
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function updateRules()
    {
        return RuleFactory::make([
            'name:ar' => ['required', 'string', 'max:255'],
            'name:en' => ['nullable','string', 'max:255'],
            'description:ar' => ['required', 'string', 'max:255'],
            'description:en' => ['nullable','string', 'max:255'],
            'price' => ['sometimes', 'required', 'numeric'],
            'has_discount' => ['nullable', 'boolean'],
            'offer_price' => [
                'sometimes',
                Rule::requiredIf(function () {
                    return $this->has_discount;
                }),
            ],
            'category_id' => [
                'sometimes',
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
            'quantity' => ['sometimes', 'required', 'numeric'],
            'colors' => ['sometimes', 'nullable', 'array'],
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
            'sizes' => ['sometimes', 'nullable', 'array'],
            'sizes.*.size' => [
                'string',
                Rule::requiredIf(function () {
                    return is_array($this->sizes);
                }),
            ],
            'images' => ['sometimes', 'required', 'array'],
            'images.*' => ['required', new ImageRule()],
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
