<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\Concerns\WithHashedPassword;
use App\Models\User;
use App\Rules\ImageRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class RegisterRequest extends FormRequest
{
    use WithHashedPassword;

    /**
     * Determine if the supervisor is authorized to make this request.
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
        return [
            'name' => ['required', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'phone' => ['required', 'unique:users,phone'],
            'password' => ['required', 'min:6', 'confirmed'],
            'avatar' => ['nullable', 'image'],
            'type' => [
                'required',
                Rule::in([
                    User::SHOP_OWNER_TYPE,
                    User::DELEGATE_TYPE,
                    User::CUSTOMER_TYPE,
                ]),
            ],
            'shop_name' => [
                Rule::requiredIf(function () {
                    return $this->type == User::SHOP_OWNER_TYPE;
                }),
            ],
            'shop_description' => [
                Rule::requiredIf(function () {
                    return $this->type == User::SHOP_OWNER_TYPE;
                }),
            ],
            'shop_logo' => [
                new ImageRule(),
                Rule::requiredIf(function () {
                    return $this->type == User::SHOP_OWNER_TYPE;
                }),
            ],
            'shop_banner' => [
                new ImageRule(),
                //Rule::requiredIf(function () {
                //    return $this->type == User::SHOP_OWNER_TYPE;
                //}),
            ],
            'shop_lat' => [
                'regex:/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/',
                //Rule::requiredIf(function () {
                //    return $this->type == User::SHOP_OWNER_TYPE;
                //}),
            ],
            'shop_lng' => [
                'regex:/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/',
                //Rule::requiredIf(function () {
                //    return $this->type == User::SHOP_OWNER_TYPE;
                //}),
            ],
            'national_front_image' => [
                new ImageRule(),
                Rule::requiredIf(function () {
                    return $this->type == User::DELEGATE_TYPE;
                }),
            ],
            'national_back_image' => [
                new ImageRule(),
                Rule::requiredIf(function () {
                    return $this->type == User::DELEGATE_TYPE;
                }),
            ],
            'vehicle_image' => [
                new ImageRule(),
                Rule::requiredIf(function () {
                    return $this->type == User::DELEGATE_TYPE;
                }),
            ],
            'national_id' => [
                Rule::requiredIf(function () {
                    return $this->type == User::DELEGATE_TYPE;
                }),
            ],
            'vehicle_type' => [
                Rule::requiredIf(function () {
                    return $this->type == User::DELEGATE_TYPE;
                }),
            ],
            'vehicle_model' => [
                Rule::requiredIf(function () {
                    return $this->type == User::DELEGATE_TYPE;
                }),
            ],
            'vehicle_number' => [
                Rule::requiredIf(function () {
                    return $this->type == User::DELEGATE_TYPE;
                }),
            ],
            'shop_category_id' => [
                Rule::requiredIf(function () {
                    return $this->type == User::SHOP_OWNER_TYPE;
                }),
                'exists:categories,id',
            ],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        switch (request('type')) {
            case User::SHOP_OWNER_TYPE:
                $attributes = collect(trans('shops.attributes'))->mapWithKeys(function ($value, $key) {
                    return ['shop_'.$key => $value];
                })->merge(trans('shop_owners.attributes'))->toArray();
                break;
            case User::DELEGATE_TYPE:
                $attributes = trans('delegates.attributes');
                break;
            case User::CUSTOMER_TYPE:
            default:
                $attributes = trans('customers.attributes');
                break;
        }

        return Arr::dot($attributes);
    }

    /**
     * Get the data that starts with the given prefix from request.
     *
     * @param $prefix
     * @return array
     */
    public function prefixedWith($prefix)
    {
        return collect($this->all())->filter(function ($value, $key) use ($prefix) {
            return Str::startsWith($key, $prefix);
        })->mapWithKeys(function ($value, $key) use ($prefix) {
            return [str_replace($prefix, '', $key) => $value];
        })->toArray();
    }
}
