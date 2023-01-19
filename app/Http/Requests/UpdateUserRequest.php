<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'name' => 'required|max:255',
            // 'username' => 'required|unique:users,username,'. $this->user.'|max:255',
            // 'email' => 'required|unique:users,email,'. $this->user.'|max:255',
            // 'phone' => 'required|unique:users,phone,'. $this->user.'|max:11|min:11',
           'username' => 'max:255|required|unique:users,username,' . $this->id . ',id,clinic_id,' . $this->clinic_id,
           'email' => 'max:255|required|unique:users,email,' . $this->id . ',id,clinic_id,' . $this->clinic_id,
           'phone' => 'max:11|min:11|required|unique:users,phone,' . $this->id . ',id,clinic_id,' . $this->clinic_id,
            'job' => 'required',
           'password' => 'sometimes',

        ];
    }
    protected function prepareForValidation(){
        if($this->password == null){
            $this->request->remove('password');
        }
    }
}
