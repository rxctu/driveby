<?php

namespace App\Http\Requests;

use App\Models\Setting;
use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
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
            'delivery_name' => 'required|string|max:255',
            'delivery_email' => 'required|email|max:255',
            'delivery_phone' => 'required|string|max:20',
            'delivery_address' => 'required|string|max:500',
            'delivery_city' => 'required|string|max:255',
            'delivery_postal_code' => 'required|string|size:5|regex:/^63/',
            'delivery_slot_id' => 'nullable|integer|exists:delivery_slots,id',
            'payment_method' => 'required|string|in:' . $this->allowedPaymentMethods(),
            'notes' => 'nullable|string|max:1000',
            'terms_accepted' => 'accepted',
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
            'delivery_name.required' => 'Le nom du destinataire est obligatoire.',
            'delivery_email.required' => 'L\'adresse email est obligatoire.',
            'delivery_email.email' => 'Veuillez fournir une adresse email valide.',
            'delivery_phone.required' => 'Le numero de telephone est obligatoire.',
            'delivery_address.required' => 'L\'adresse de livraison est obligatoire.',
            'delivery_city.required' => 'La ville est obligatoire.',
            'delivery_postal_code.required' => 'Le code postal est obligatoire.',
            'delivery_postal_code.size' => 'Le code postal doit contenir exactement 5 caracteres.',
            'delivery_postal_code.regex' => 'Nous livrons uniquement dans le departement 63 (Puy-de-Dome).',
            'payment_method.required' => 'Veuillez choisir un mode de paiement.',
            'payment_method.in' => 'Le mode de paiement selectionne n\'est pas valide.',
            'terms_accepted.accepted' => 'Vous devez accepter les conditions generales de vente.',
        ];
    }

    /**
     * Get custom attribute names.
     *
     * @return array<string, string>
     */
    private function allowedPaymentMethods(): string
    {
        $onlineEnabled = Setting::getValue('online_payments_enabled', '1') === '1';

        return $onlineEnabled ? 'cash,stripe,paypal' : 'cash';
    }

    public function attributes(): array
    {
        return [
            'delivery_name' => 'nom',
            'delivery_email' => 'email',
            'delivery_phone' => 'telephone',
            'delivery_address' => 'adresse',
            'delivery_city' => 'ville',
            'delivery_postal_code' => 'code postal',
            'delivery_slot_id' => 'creneau de livraison',
            'payment_method' => 'mode de paiement',
            'notes' => 'notes',
        ];
    }
}
