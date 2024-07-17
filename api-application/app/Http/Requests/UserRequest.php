<?php

namespace App\Http\Requests;

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
            case 'PUT':
                return [
                    "nama" => "required|string",
                    "email" => "required|string",
                    "password" => "required|string",
                    "whatsapp" => "required|string",
                    "foto_profile" => "string",
                ];
            default:
                return [];
        }
    }
}
