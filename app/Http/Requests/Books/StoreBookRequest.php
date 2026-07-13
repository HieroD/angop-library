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

    /**
     * Get custom validation messages.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Judul buku wajib diisi.',
            'title.string' => 'Judul buku harus berupa teks.',
            'title.max' => 'Judul buku maksimal 255 karakter.',
            'book_cover.image' => 'Sampul buku harus berupa gambar.',
            'book_cover.max' => 'Sampul buku maksimal 2 MB.',
            'isbn.string' => 'ISBN harus berupa teks.',
            'isbn.max' => 'ISBN maksimal 13 karakter.',
            'isbn.unique' => 'ISBN sudah digunakan oleh buku lain.',
            'author_id.integer' => 'Penulis yang dipilih tidak valid.',
            'author_id.exists' => 'Penulis yang dipilih tidak ditemukan.',
            'author_id.required_without' => 'Pilih penulis dari daftar atau masukkan nama penulis baru.',
            'author_name.string' => 'Nama penulis harus berupa teks.',
            'author_name.max' => 'Nama penulis maksimal 255 karakter.',
            'author_name.required_without' => 'Pilih penulis dari daftar atau masukkan nama penulis baru.',
            'category_id.integer' => 'Kategori yang dipilih tidak valid.',
            'category_id.exists' => 'Kategori yang dipilih tidak ditemukan.',
            'category_id.required_without' => 'Pilih kategori dari daftar atau masukkan nama kategori baru.',
            'category_name.string' => 'Nama kategori harus berupa teks.',
            'category_name.max' => 'Nama kategori maksimal 255 karakter.',
            'category_name.required_without' => 'Pilih kategori dari daftar atau masukkan nama kategori baru.',
            'publisher.string' => 'Penerbit harus berupa teks.',
            'publisher.max' => 'Penerbit maksimal 255 karakter.',
            'published_year.required' => 'Tahun terbit wajib diisi.',
            'published_year.integer' => 'Tahun terbit harus berupa angka.',
            'published_year.min' => 'Tahun terbit minimal tahun 1000.',
            'published_year.max' => 'Tahun terbit tidak boleh melebihi tahun ini.',
            'total_copies.required' => 'Stok wajib diisi.',
            'total_copies.integer' => 'Stok harus berupa angka.',
            'total_copies.min' => 'Stok tidak boleh kurang dari 0.',
            'description.string' => 'Deskripsi harus berupa teks.',
        ];
    }
}
