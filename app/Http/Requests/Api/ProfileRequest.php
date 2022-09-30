<?php

namespace App\Http\Requests\Api;

use App\Models\User;
use App\Rules\ImageRule;
use App\Rules\PasswordRule;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Concerns\WithHashedPassword;

class ProfileRequest extends FormRequest
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
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'old_password' => ['required_with:password', new PasswordRule(auth()->user()->password)],
            'password' => ['nullable', 'min:6', 'confirmed'],
            'avatar' => ['nullable', new ImageRule()],
            'address' => ['nullable', 'string', 'max:255'],
            'city_id' => ['nullable', 'exists:cities,id'],
            'shop_name' => [
                'sometimes',
                Rule::requiredIf(function () {
                    return auth()->user()->type == User::SHOP_OWNER_TYPE;
                }),
            ],
            'shop_description' => [
                'sometimes',
                Rule::requiredIf(function () {
                    return auth()->user()->type == User::SHOP_OWNER_TYPE;
                }),
            ],
            'shop_logo' => [
                new ImageRule(),
            ],
            'shop_banner' => [
                new ImageRule(),
            ],
            'national_front_image' => [
                new ImageRule(),
            ],
            'national_back_image' => [
                new ImageRule(),
            ],
            'vehicle_image' => [
                new ImageRule(),
            ],
            'national_id' => [
                'sometimes',
                Rule::requiredIf(function () {
                    return $this->type == User::DELEGATE_TYPE;
                }),
            ],
            'vehicle_type' => [
                'sometimes',
                Rule::requiredIf(function () {
                    return $this->type == User::DELEGATE_TYPE;
                }),
            ],
            'vehicle_model' => [
                'sometimes',
                Rule::requiredIf(function () {
                    return $this->type == User::DELEGATE_TYPE;
                }),
            ],
            'vehicle_number' => [
                'sometimes',
                Rule::requiredIf(function () {
                    return $this->type == User::DELEGATE_TYPE;
                }),
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
        switch (auth()->user()->type) {
            case User::ADMIN_TYPE:
                return trans('admins.attributes');
                break;
            case User::DELEGATE_TYPE:
                return trans('delegates.attributes');
                break;
            case User::CUSTOMER_TYPE:
            default:
                return trans('customers.attributes');
                break;
        }
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
