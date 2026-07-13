<?php

namespace App\Http\Requests\Returns;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class StoreReturnRequest extends FormRequest
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
                $borrowing = $this->route('borrowing');

                if (! in_array($borrowing?->status, ['dipinjam', 'terlambat'], true)) {
                    $validator->errors()->add('borrowing', 'Peminjaman ini tidak dapat dikembalikan.');
                }

                if ($borrowing?->returnRecord()->exists()) {
                    $validator->errors()->add('borrowing', 'Peminjaman ini sudah dikembalikan.');
                }
            },
        ];
    }
}
