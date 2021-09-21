@extends('layouts.admin')
@section('content')
<div class="form-group">
    <button class="btn btn-secondary" type="submit">
        {{ trans('global.back') }}
    </button>
</div>
<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.department.title_singular') }}
    </div>
    <div class="card-body">
        <form action="{{ route("admin.departments.store") }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="title" class="required">{{ trans('cruds.department.fields.title')}}</label>
                <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" type="text" name="title" id="title" value="{{ old('title', '') }}" required>
                @if($errors->has('title'))
                <span class="text-danger">{{ $errors->first('title') }}</span>
                @endif
            </div>
            <div class="form-group">
                <label for="parent_id" class="required">{{ trans('cruds.department.fields.head')}}</label>
                <select class="js-example-basic-single w-100 select2-hidden-accessible {{ $errors->has('parent_id') ? 'is-invalid' : '' }}" name="parent_id" data-width="100%" aria-hidden="true">
                    <option value=""​>--- Choose department ---</option>
                    @foreach ($departments as $id => $department)
                        <option value="{{ $id }}"​>{{ $department }}</option>
                    @endforeach
                </select>
                @if($errors->has('parent_id'))
                    <span class="text-danger">{{ $errors->first('parent_id') }}</span>
                @endif
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
