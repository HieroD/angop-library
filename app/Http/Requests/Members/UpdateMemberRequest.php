<?php

namespace App\Http\Requests\Members;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateMemberRequest extends FormRequest
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
        $memberId = $this->route('member')?->getKey();

        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('members', 'email')->ignore($memberId), Rule::unique('staffs', 'email')],
            'password' => ['nullable', 'string', 'min:8'],
            'phone' => ['nullable', 'string', 'max:20', 'regex:/^[0-9+()\s-]+$/'],
            'gender' => ['nullable', Rule::in(['M', 'F'])],
            'date_of_birth' => ['nullable', 'date'],
            'address' => ['nullable', 'string'],
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
            'name.required' => 'Nama anggota wajib diisi.',
            'name.string' => 'Nama anggota harus berupa teks.',
            'name.max' => 'Nama anggota maksimal 255 karakter.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Email harus berupa alamat email yang valid.',
            'email.max' => 'Email maksimal 255 karakter.',
            'email.unique' => 'Email sudah digunakan di sistem.',
            'password.string' => 'Password harus berupa teks.',
            'password.min' => 'Password minimal 8 karakter.',
            'phone.string' => 'Telepon harus berupa teks.',
            'phone.max' => 'Telepon maksimal 20 karakter.',
            'phone.regex' => 'Telepon hanya boleh berisi angka dan simbol telepon.',
            'gender.in' => 'Jenis kelamin tidak valid.',
            'date_of_birth.date' => 'Tanggal lahir harus berupa tanggal yang valid.',
            'address.string' => 'Alamat harus berupa teks.',
        ];
    }
}
