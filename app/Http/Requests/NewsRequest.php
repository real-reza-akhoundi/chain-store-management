<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // only allow updates if the user is logged in
        return backpack_auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if($this->isMethod('put')){
            return [
                'title' => 'required|max:255',
                'description' => 'required|max:255',
                'body' => 'required',
                'image' => 'file|mimes:jpg,png,jpeg',

            ];
        }
        return [
            'title' => 'required|max:255',
            'description' => 'required|max:255',
            'body' => 'required',
            'image' => 'required|file|mimes:jpg,png,jpeg',
        ];
    }

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            //
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            //
        ];
    }
}
