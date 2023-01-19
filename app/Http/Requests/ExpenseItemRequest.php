<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExpenseItemRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $this->clinic_id=app('clinic_id');
        return [
            'name' => 'required|unique:expense_items,name,' . $this->id . ',id,clinic_id,' . $this->clinic_id,
        ];
    }
}
