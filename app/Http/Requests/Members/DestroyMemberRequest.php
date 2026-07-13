<?php

namespace App\Http\Requests\Members;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class DestroyMemberRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth('staff')->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email_confirmation' => ['required', 'string'],
        ];
    }

    /**
     * Get custom validation messages.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'email_confirmation.required' => 'Konfirmasi email anggota wajib diisi.',
            'email_confirmation.string' => 'Konfirmasi email anggota harus berupa teks.',
        ];
    }

    /**
     * Get the "after" validation callables for the request.
     *
     * @return array<int, callable>
     */
    public function after(): array
    {
        return [
            function (Validator $validator): void {
                if ($this->input('email_confirmation') !== $this->route('member')?->email) {
                    $validator->errors()->add('email_confirmation', 'Konfirmasi email anggota tidak sesuai.');
                }
            },
        ];
    }
}
