<?php

namespace App\Http\Requests\Channel;

use App\Models\Channel;
use Illuminate\Foundation\Http\FormRequest;
use Gate;
use Illuminate\Http\Response;

class StoreChannelRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('channel_create');
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
