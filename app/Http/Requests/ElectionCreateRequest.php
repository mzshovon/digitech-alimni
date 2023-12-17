<?php

namespace App\Http\Requests;

use App\Rules\CheckActiveElection;
use Illuminate\Foundation\Http\FormRequest;

class ElectionCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => ['required', "string"],
            'status' => ['required', "string", new CheckActiveElection()],
            'start_date' => ['required', "string"],
            'end_date' => ['required', "string"],
            'positions' => ['nullable', 'array'],
        ];
    }
}
