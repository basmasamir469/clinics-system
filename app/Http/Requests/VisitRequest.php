<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Http\FormRequest;

class VisitRequest extends FormRequest
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
         return [
                'visit_results'=>'required|min:80',
                ];
        }
        public function withValidator($validator)
        {
            if ($validator->fails()) {
                Session::flash('error', 'add visit results validation failed!');
            }
        
        }
        public function messages(){
            return [
                'visit_results.required'=>'you must add results first '
            ];
        }

    }
