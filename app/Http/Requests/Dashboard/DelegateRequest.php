<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Concerns\WithHashedPassword;

class DelegateRequest extends FormRequest
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
            'type' => ['sometimes', 'nullable', Rule::in(array_keys(trans('users.types')))],
            'city_id' => ['nullable', 'exists:cities,id'],
            'national_id' => ['required'],
            'vehicle_type' => ['required'],
            'vehicle_model' => ['required'],
            'vehicle_number' => ['required'],
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
            'email' => ['required', 'email', 'unique:users,email,' . $this->route('delegate')->id],
            'phone' => ['required', 'unique:users,phone,' . $this->route('delegate')->id],
            'password' => ['nullable', 'min:6', 'confirmed'],
            'type' => ['sometimes', 'nullable', Rule::in(array_keys(trans('users.types')))],
            'city_id' => ['nullable', 'exists:cities,id'],
            'national_front_image' => ['sometimes', 'image'],
            'national_back_image' => ['sometimes', 'image'],
            'vehicle_image' => ['sometimes', 'image'],
            'national_id' => ['sometimes', 'required'],
            'vehicle_type' => ['sometimes', 'required'],
            'vehicle_model' => ['sometimes', 'required'],
            'vehicle_number' => ['sometimes', 'required'],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return trans('delegates.attributes');
    }
}
