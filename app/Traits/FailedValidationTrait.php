<?php
namespace App\Traits;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
trait FailedValidationTrait {
    protected function failedValidation(Validator $validator, $message =null)
    {
        if(is_null($message)) {
            $message = implode( ',' ,  $validator->errors()->all());
        }
        throw new HttpResponseException(response()->fail( message: $message, code: 422));
    }
}
