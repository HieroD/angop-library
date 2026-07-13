<?php

namespace App\Http\Requests\Returns;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class UpdateReturnPaymentRequest extends FormRequest
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
            'amount' => ['required', 'numeric', 'min:0'],
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
            'amount.required' => 'Jumlah pembayaran wajib diisi.',
            'amount.numeric' => 'Jumlah pembayaran harus berupa angka.',
            'amount.min' => 'Jumlah pembayaran tidak boleh kurang dari 0.',
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
                $returnRecord = $this->route('returnRecord');

                if ($returnRecord?->payment_status === 'paid') {
                    $validator->errors()->add('amount', 'Denda sudah lunas.');

                    return;
                }

                $remainingFine = (float) $returnRecord?->fine_amount - (float) $returnRecord?->paid_amount;

                if ((float) $this->input('amount') > $remainingFine) {
                    $validator->errors()->add('amount', 'Jumlah pembayaran melebihi sisa denda.');
                }
            },
        ];
    }
}
