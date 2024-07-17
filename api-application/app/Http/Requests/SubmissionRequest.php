<?php

namespace App\Http\Requests;

class SubmissionRequest extends CoreRequest
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
                    "tantangan_id" => "string|required",
                    "file" => "string|required",
                    "link" => "string|required",
                ];
            default:
                return [];
        }
    }
}
