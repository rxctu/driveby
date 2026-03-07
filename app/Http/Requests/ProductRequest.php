<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'category_id' => 'required|integer|exists:categories,id',
            'description' => 'nullable|string|max:5000',
            'price' => 'required|numeric|min:0|max:99999.99',
            'stock' => 'required|integer|min:0|max:99999',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'is_active' => 'boolean',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_active' => $this->boolean('is_active', true),
        ]);
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Le nom du produit est obligatoire.',
            'category_id.required' => 'Veuillez selectionner une categorie.',
            'category_id.exists' => 'La categorie selectionnee n\'existe pas.',
            'price.required' => 'Le prix est obligatoire.',
            'price.numeric' => 'Le prix doit etre un nombre.',
            'image.image' => 'Le fichier doit etre une image.',
            'image.mimes' => 'L\'image doit etre au format JPG, PNG ou WebP.',
            'image.max' => 'L\'image ne doit pas depasser 5 Mo.',
        ];
    }
}
