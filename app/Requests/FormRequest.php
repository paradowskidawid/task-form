<?php

namespace App\Requests;

use Illuminate\Support\Facades\Validator;

class FormRequest
{
    public static function FormRequest(array $data)
    {
        $validator = Validator::make($data, [
            'fullName' => 'required|string|max:100',
            'phoneNumber' => 'required|numeric',
            'email' => 'required|email',
            'message' => 'required|string|max:500',
            'file' => 'required|mimes:jpg,pdf|max:5120',
        ]);

        return $validator->passes();
    }
}
