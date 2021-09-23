<?php

namespace App\Http\Requests\Department;

use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateDepartmentRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('department_edit');
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
