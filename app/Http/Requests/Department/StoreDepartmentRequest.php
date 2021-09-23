<?php

namespace App\Http\Requests\Department;

use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreDepartmentRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('department_create');
    }

    public function rules()
    {
        return [
            'title' => [
                'string',
                'required',
                'min:5'
            ],
        ];
    }
}
