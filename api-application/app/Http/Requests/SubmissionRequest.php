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
                    "length" => "required|integer|min:1",
                ];
            case 'POST':
                return [
                    "tantangan_id" => "required|integer",
                    "file" => "nullable|string|required_without_all:link",
                    "link" => "nullable|string|required_without_all:file",
                ];
            case 'PUT':
                return [
                    "feedback" => "nullable|string",
                    "peringkat" => "required|integer",
                ];
            default:
                return [];
        }
    }
}
