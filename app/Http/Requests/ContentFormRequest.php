<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContentFormRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name'=>'required|string|min:3',
            'email'=>'required|email',
            'subject'=>'required',
            'message'=>'required',

        ];
    }


    public function messages(): array
    {
        return [
            'name.required' => 'Lütfen İsim Soyisim Kısmını Doldurunuz.',
            'name.string' => 'İsim Soyisim Kısmı Karakterlerden Oluşmalıdır.',
            'name.min' => ' İsim Soyisim Kısmı Minimum 3 Karakterden Oluşmalıdır.',
            'email.required' => 'Lütfen E-posta Kısmını Doldurunuz.',
            'email.email' => 'Geçersiz bir Email Adresi Girdiniz.',
            'subject.required' => 'Konu Kısmı Boş Geçilemez.',
            'message.required' => 'Mesaj Kısmı Boş Geçilemez.',


        ];
    }
}

