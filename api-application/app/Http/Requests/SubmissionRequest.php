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
                    "tantangan_id" => "nullable|integer",
                    "length" => "required|integer",
                ];
            case 'POST':
                return [
                    "tantangan_id" => "required|string",
                    "file" => "nullable|string|required_without_all:link",
                    "link" => "nullable|string|required_without_all:file",
                ];
            case 'PUT':
                return [
                    "feedback" => "required|string",
                    "peringkat" => "required|integer",
                ];
            default:
                return [];
        }
    }
}
