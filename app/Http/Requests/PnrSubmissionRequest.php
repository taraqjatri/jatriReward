<?php

namespace App\Http\Requests;

use App\Enums\AdminTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class PnrSubmissionRequest extends FormRequest
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
            'status' => ['nullable', 'string'],
            'date_range' => ['nullable', 'regex:/\d{2}\/\d{2}\/\d{4}\s-\s\d{2}\/\d{2}\/\d{4}/'],
            'pnr' => ['nullable','string'],
            'number' => ['nullable', 'numeric'],
            'vehicle_no' => ['nullable', 'string'],
            'seller_number' => ['nullable', 'numeric']
        ];
    }
}
