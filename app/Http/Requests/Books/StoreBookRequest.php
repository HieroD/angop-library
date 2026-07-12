<?php

namespace App\Http\Requests\Books;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;

class StoreBookRequest extends FormRequest
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
            'title' => ['required', 'string', 'max:255'],
            'book_cover' => ['nullable', File::image()->max('2mb')],
            'isbn' => ['nullable', 'string', 'max:13', Rule::unique('books', 'isbn')],
            'author_id' => ['nullable', 'integer', Rule::exists('authors', 'id'), 'required_without:author_name'],
            'author_name' => ['nullable', 'string', 'max:255', 'required_without:author_id'],
            'category_id' => ['nullable', 'integer', Rule::exists('categories', 'id'), 'required_without:category_name'],
            'category_name' => ['nullable', 'string', 'max:255', 'required_without:category_id'],
            'publisher' => ['nullable', 'string', 'max:255'],
            'published_year' => ['required', 'integer', 'min:1000', 'max:'.now()->year],
            'total_copies' => ['required', 'integer', 'min:0'],
            'description' => ['nullable', 'string'],
        ];
    }
}
