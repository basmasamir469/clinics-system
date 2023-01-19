<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class StoreAppointmentsRequest extends FormRequest
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
            'patient' => 'required',
            // 'date' => 'required|after_or_equal:now',
            'date' => ['required', 'after_or_equal:' . Carbon::now('Africa/Cairo')->toDateString()],

            'time' => 'required',
            'services' => 'required',
            'services.*' => 'required',
            'advance' => '',
            'notes' => 'string',
        ];
    }
}
