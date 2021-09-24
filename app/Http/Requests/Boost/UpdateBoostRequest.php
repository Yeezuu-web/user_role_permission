<?php

namespace App\Http\Requests\Boost;

use Gate;
use Illuminate\Foundation\Http\FormRequest;

class UpdateBoostRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('boost_edit');
    }

    public function rules()
    {
        return [
            'requester_name' => [
                'required',
                'string',
                'min:3'
            ],
            'company_name' => [
                'required',
                'string',
                'min:3'
            ],
            'budget' => [
                'required',
                'integer'
            ],
            'program_name' => [
                'required',
                'string',
                'min:3'
            ],
            'boost_start' => [
                'required',
                'date'
            ],
            'detail' => [
                'nullable',
                'string'
            ],
            'status' => [
                'nullable'
            ],
            'channel_id' => [
                'required',
            ]
        ];
    }
}
