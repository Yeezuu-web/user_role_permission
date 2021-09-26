<?php

namespace App\Http\Requests\Boost;

use Illuminate\Foundation\Http\FormRequest;
use Gate;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyBoostRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('boost_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    
    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:boosts,id',
        ];
    }
}
