<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class AdditionRequest extends FormRequest
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
            'name' => 'without_spaces|required|unique:additions,name,'.$this->id.',id,addition_for,'.$this->addition_for.',clinic_id,'.$this->clinic_id,
        //  'name' => 'without_spaces|required|unique:additions,name,' . $this->id . ',id,addition_for,' . $this->addition_for,
            'addition_for' => 'required|numeric|min:1|max:3',
            'addition_type' => 'required|numeric|min:1|max:3',
            'type'=>'required',
        ];
    }

    public function messages(){
        return [
        'name.without_spaces' => 'sorry no space allowed for addition name'
        ];
    }

    
}
