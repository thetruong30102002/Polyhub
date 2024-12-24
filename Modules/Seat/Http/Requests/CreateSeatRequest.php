<?php

namespace Modules\Seat\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Seat\Entities\Seat;

class CreateSeatRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'column' => 'required',
            'row' => 'required',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    protected function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->seatExists()) {
                $validator->errors()->add('row', 'This seat already exists');
            }
        });
    }

    protected function seatExists()
    {
        return Seat::where('row', $this->row)
                   ->where('column', $this->column)
                   ->exists();
    }
}
