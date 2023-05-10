<?php

namespace App\Http\Requests;

use App\Enum\AdminTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class AdminCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string'],
            'phone' => ['required', 'unique:admins,phone', 'string'],
            'email' => ['required','unique:admins,email','min:5', 'max:100','regex:/^[a-zA-Z0-9-@._]+$/'],
            'password' => ['required', 'confirmed', 'min:6', 'max:255'],
            'admin_type' => ['required', Rule::in(array_column(AdminTypeEnum::cases(),'value'))],
            'avatar' => ['nullable', 'mimes:jpeg,jpg,png,gif|required|max:10000']
        ];
    }
}
