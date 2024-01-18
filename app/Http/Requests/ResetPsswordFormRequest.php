<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class ResetPsswordFormRequest extends FormRequest
{
    public function authorize(): bool
    {
//        return auth()->guest();
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
                'token' => 'required',
                'email' => 'required|email',
                'password' => 'required|min:8|confirmed',
        ];
    }

}
