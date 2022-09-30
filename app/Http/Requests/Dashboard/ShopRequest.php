<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class ShopRequest extends FormRequest
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
        if ($this->isMethod('POST')) {
            return $this->createRules();
        } else {
            return $this->updateRules();
        }


      
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */

    public function createRules()
    {
        return [
            'user_id' => ['required', 'exists:users,id'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'category_id' => ['required', 'exists:categories,id'],
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
            'description' => ['required', 'string'],
        ];
    }
    public function attributes()
    {
        return trans('shops.attributes');
    }
}
