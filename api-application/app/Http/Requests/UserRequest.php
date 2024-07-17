<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UserRequest extends CoreRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        switch ($this->getMethod()) {
            case 'GET':
                return [
                    "search" => "nullable|string",
                    "length" => "required|integer",
                ];
            case 'POST':
                return [
                    "nama" => "required|string",
                    "email" => [
                        "required",
                        "string",
                        Rule::unique("user", "email")
                    ],
                    "password" => "required|string",
                    "whatsapp" => "required|string",
                ];
            case 'PUT':
                return [
                    "nama" => "required|string",
                    "email" => [
                        "required",
                        "string",
                        Rule::unique("user", "email")->ignore(Auth::user()->id)
                    ],
                    "password" => "required|string",
                    "whatsapp" => "required|string",
                    "foto_profile" => "string",
                ];
            default:
                return [];
        }
    }
}
