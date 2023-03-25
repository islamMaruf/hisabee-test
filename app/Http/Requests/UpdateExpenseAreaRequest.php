<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateExpenseAreaRequest extends FormRequest
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
            'name' => 'required|string|max:100|unique:expense_areas,name' . $this->id,
            'image' => 'nullable|image|size:2048|mimes:jpeg,png,jpg',
            'image_url' => 'nullable|string'

        ];
    }
}
