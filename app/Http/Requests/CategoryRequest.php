<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
    // 🔒 CHI PUÒ USARE QUESTA REQUEST
    public function authorize(): bool
    {
        return true; // In un'app reale, controlli i permessi qui
    }

    // 📝 REGOLE DI VALIDAZIONE
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_white' => 'boolean'
        ];
    }

    // 🏷️ PREPARA I DATI DOPO LA VALIDAZIONE
    protected function prepareForValidation(): void
    {
        // Converte checkbox in boolean
        $this->merge([
            'is_white' => $this->boolean('is_white')
        ]);
    }

    // ✅ MESSAGGI DI ERRORE PERSONALIZZATI (opzionale)
    public function messages(): array
    {
        return [
            'name.required' => 'Il nome della categoria è obbligatorio.',
            'name.max' => 'Il nome non può essere più lungo di 255 caratteri.'
        ];
    }
}