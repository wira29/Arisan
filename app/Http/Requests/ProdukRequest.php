<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProdukRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
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
            'nama' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'harga_beli' => 'required|numeric',
            'harga_jual' => ['required', 'numeric', 'gt:harga_beli'],
            'gambar' => 'mimes:jpeg,png,jpg',
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array<string, string>
     */
    public function messages()
    {
        return [
            'nama.required' => 'Nama produk wajib diisi',
            'category_id.required' => 'Kategori produk wajib diisi',
            'category_id.exists' => 'Kategori tidak ditemukan',
            'harga_beli.required' => 'Harga beli wajib diisi',
            'harga_jual.required' => 'Harga jual wajib diisi',
            'harga_beli.numeric' => 'Harga beli harus berupa angka',
            'harga_jual.numeric' => 'Harga jual harus berupa angka',
            'harga_jual.gt' => 'Harga jual harus lebih besar dari harga beli',
        ];
    }
}
