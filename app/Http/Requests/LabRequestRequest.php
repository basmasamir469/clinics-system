<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Session;

class LabRequestRequest extends FormRequest
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
        return
         [
            'laboratory_id'=>'required',
            ];
    }
    public function messages(){
    return [
        'laboratory_id.required'=>'please choose lab'
    ];
}
public function withValidator($validator)
{
    if ($validator->fails()) {
        Session::flash('errorrequest', 'lab request validation failed!');
    }

}


    }
