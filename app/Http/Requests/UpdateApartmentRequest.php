<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateApartmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|unique:apartments|min:5|max:255',
            'beds_num' => 'required|numeric',
            'rooms_num' => 'required|numeric',
            'bathrooms_num' => 'required|numeric',
            'square_meters' => 'required|numeric',
            'address' => 'min:5|max:255',          
            'visibility' => 'required|boolean',
            'image' => 'image|max:1024|nullable'
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Title field is required!',
            'title.unique:apartments' => 'This title already exist!',
            'title.max' => 'The length of the title must not exceed :max characters!',
            'title.min' => 'The length of the title must be at least :min characters!',
            'image.max' => 'The weight of the image cannot exceed 1MB!'
        ];
    }
}
