<?php

namespace App\Exceptions;

use Exception;

class CustomException extends Exception
{
    protected $message;
    public function __construct(string $message = "")
    {
        $this->message = $message;
    }
    public function report()
    {
        \Log::info('Throwed Exception : '.$this->message);
    }
    public function render($request)
    {
        return response()->fail('Something Went Wrong!', 500);
    }
}
