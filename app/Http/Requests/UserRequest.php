<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Auth;

class UserRequest extends FormRequest
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
        return [
            'name' => 'required|between:3,25|regex:/^[A-Za-z0-9\-\_]+$/|unique:users,name,' . Auth::id(),
			'email' => 'required|email',
			'introduction' => 'max:80',
			'avatar' => 'mimes:jpeg,bmp,png,gif|dimensions:min_width=200,min_height=200'
        ];
    }

	public function messages() {
		return [
			'name.require' => 'This name has been taken',
			'name.regex' => 'U can only use alphabet, num, _, -',
			'name.between' => 'The name must be between 3 - 25',
			'name.required' => 'The name can\'t be null',
			'avatar.mimes' => 'Must be jpeg, bmp, png, gif',
			'avatar.dimensions' => 'Width and height must be 200px'
		];
	}
}