<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PatientRequest extends FormRequest
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
            // 'id'=>'required|max:7',
            'name' => 'required|unique:patients,name,' . $this->id . ',id,clinic_id,' . $this->clinic_id,
            'phone'=>'required',
            'email'=>'required|email:rfc|email:strict',
            'area_id'=>'required|exists:areas,id',
            'gender'=>'required',
            'insurance_id'=>'required|exists:insurances,id',
        ];
    }
    // public function messages(){

    //     return [
    //         'id.required'=>__('messages.id required'),
    //         'id.max'=>__('messages.id max'),
    //         'name.required'=>__('messages.name required'),
    //         'name.unique'=>__('messages.name unique'),
    //         'phone.required'=>__('messages.phone required'),
    //         'phone.unique'=>__('messages.phone unique'),
    //         'email.required'=>__('messages.email required'),
    //         'email.unique'=>__('messages.email unique')




    //     ];

    // }
}
