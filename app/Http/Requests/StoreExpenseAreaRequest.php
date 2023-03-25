<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StoreExpenseAreaRequest extends FormRequest
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
     * @return array<string, Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|unique:expense_areas|string|max:100',
            'note' => 'nullable|string|max:1000',
            'image' => 'nullable|image|max:2048|mimes:jpeg,png,jpg',
            'image_url'=> 'nullable|string'

        ];
    }
}
