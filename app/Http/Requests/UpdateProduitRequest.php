<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProduitRequest extends FormRequest
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
            //
            'designation' =>['bail','required'],
            'prix'=>['bail','required','numeric'],
            'qte'=>['bail','required','numeric'],
            'lienImage' =>['bail','required'],
            'status'=>['bail','required','boolean'],
            'categorie_id'=>['bail','required','numeric']
        ];
    }
}
