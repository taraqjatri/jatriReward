<?php

namespace App\Http\Requests;

use App\Models\UserPNRSubmission;
use App\Rules\NoWhiteSpaceRule;
use Illuminate\Foundation\Http\FormRequest;
use App\Traits\FailedValidationTrait;
use Illuminate\Validation\ValidationException;

class PNRStoreRequest extends FormRequest
{
    use FailedValidationTrait;
    protected $stopOnFirstFailure = true;
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'pnr'    => ['required','min:10','max:14','unique:user_p_n_r_submissions', new NoWhiteSpaceRule()],
        ];
    }

    public function messages(): array
    {
        return [
            'pnr.unique' => 'The PNR has already been submitted.',
        ];
    }

    /**
     * @throws ValidationException
     */
    public function  prepareForValidation(): void
    {
        $today_date_db_format =  todayDateDBFormat();
        $already_submitted =  UserPNRSubmission::query()
            ->select('id', 'user_id','created_at')
            ->where('user_id', $this->user()->id)
            ->where('created_at', '>=', $today_date_db_format)
            ->where('created_at', '<=', $today_date_db_format . ' 23:59:59')
            ->count();
        if($already_submitted >= config('app.allowed_pnr_submission_for_a_user')){
            $this->failedValidation($this->getValidatorInstance(), 'Number of tickets submitted by user per day limit exceed!');
        }
    }
}
