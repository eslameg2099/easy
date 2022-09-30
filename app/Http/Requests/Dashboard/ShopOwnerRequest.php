<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Concerns\WithHashedPassword;

class ShopOwnerRequest extends FormRequest
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
        if ($this->isMethod('POST')) {
            return $this->createRules();
        } else {
            return $this->updateRules();
        }
    }

    /**
     * Get the create validation rules that apply to the request.
     *
     * @return array
     */
    public function createRules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users'],
            'phone' => ['required', 'unique:users,phone'],
            'password' => ['required', 'min:6', 'confirmed'],
            'tax'=>['nullable', 'min:1'],
            'type' => ['sometimes', 'nullable', Rule::in(array_keys(trans('users.types')))],
            'city_id' => ['nullable', 'exists:cities,id'],
        ];
    }

    /**
     * Get the update validation rules that apply to the request.
     *
     * @return array
     */
    public function updateRules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email,' . $this->route('shop_owner')->id],
            'phone' => ['required', 'unique:users,phone,' . $this->route('shop_owner')->id],
            'password' => ['nullable', 'min:6', 'confirmed'],
            'tax'=>['nullable', 'min:1'],

            'type' => ['sometimes', 'nullable', Rule::in(array_keys(trans('users.types')))],
            'city_id' => ['nullable', 'exists:cities,id'],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return trans('shop_owners.attributes');
    }
}
