<?php

namespace Modules\Actor\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ActorRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
            'name' => 'required',
            'gender' => 'required',
            'movie_id' => 'required',
            'avatar' => ['bail', 'required'],
            'avatar.*' => ['bail', 'image', 'mimes:jpeg,jpg,png,gif']
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
}
