<?php

namespace App\Http\Requests\Channel;

use Gate;
use Illuminate\Foundation\Http\FormRequest;

class UpdateChannelRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('channel_edit');
    }

    public function rules()
    {
        return [
            'title' => [
                'string',
                'required',
                'min:3'
            ]
        ];
    }
}
