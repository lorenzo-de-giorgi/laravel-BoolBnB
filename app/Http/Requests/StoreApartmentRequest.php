<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreApartmentRequest extends FormRequest
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
            'title' => 'required|min:5|max:255|unique:App\Models\apartment,title',
            'beds_num' => 'required|numeric|min:1|max:15',
            'rooms_num' => 'required|numeric|min:1|max:15',
            'bathrooms_num' => 'required|numeric|min:1|max:15',
            'square_meters' => 'required|numeric|min:1|max:1000',
            'address' => 'required|min:10|max:255',          
            'image' => 'required',
            'visibility' => 'required|boolean',
            'services' => 'required|array|min:1',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Title field is required!',
              'title.unique' => 'you cannot upload an apartment that already exist',
            'title.min' => 'The length of the title must be at least :min characters!',
            'title.max' => 'The length of the title must not exceed :max characters!',
            'beds_num.required' => 'Number of Beds is required!',
            'beds_num.numeric' => 'The field of beds numbers must be a numeric value!',
            'beds_num.min' => 'The beds number must be at least :min !',
            'beds_num.max' => 'The beds number must not exceed :max characters!',
            'rooms_num.required' => 'Number of Rooms field is required!',
            'rooms_num.numeric' => 'The field of rooms numbers must be a numeric value!',
            'rooms_num.min' => 'The rooms number must be at least :min ',
            'rooms_num.max' => 'The rooms number must not exceed :max ',
            'bathrooms_num.required' => 'Number of Bathrooms field is required!',
            'bathrooms_num.numeric' => 'The field of bathrooms numbers must be a numeric value!',
            'bathrooms_num.min' => 'The bathrooms number must be at least :min !',
            'bathrooms_num.max' => 'The bathrooms number must not exceed :max !',
            'square_meters.required' => 'Square meters field is required!',
            'square_meters.numeric' => 'The field of square meters must be a numeric value!',
            'square_meters.min' => 'The square meters must be at least :min !',
            'square_meters.max' => 'The square meters must not exceed :max !',
            'address.required' => 'Address field is required!',
            'address.min' => 'The length of the address must be at least :min characters!',
            'address.max' => 'The length of the address must not exceed :max characters!',
            'image.required' => 'Image field is required!',
            'visibility.required' => 'Visibility field is required!',
            'visibility.boolean' => 'The visibility value must be a Boolean value!',
            'services.required' => 'Devi selezionare almeno un servizio.',
            'services.min' => 'Devi selezionare almeno un servizio.',
        ];
    }
}