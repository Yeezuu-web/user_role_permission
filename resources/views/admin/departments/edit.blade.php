@extends('layouts.admin')

@section('content')
<div class="form-group">
    <a class="btn btn-secondary" href="{{ route('admin.departments.index') }}">
        {{ trans('global.back') }}
    </a>
</div>
<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.department.title_singular') }}
    </div>
    <div class="card-body">
        <form action="{{ route("admin.departments.update", [$department->id]) }}" method="POST" autocomplete="off">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="title" class="required">{{ trans('cruds.department.fields.title')}}</label>
                <input class="form-control @error('title') form-control-danger @enderror" type="text" name="title" id="title" value="{{ old('title', $department->title) }}" required>
                @error('title')
                    <label class="error mt-2 text-danger">{{ $message }}</label>
                @enderror
            </div>
            <div class="form-group">
                <label for="parent_id" class="required">{{ trans('cruds.department.fields.head')}}</label>
                <select class="js-example-basic-single w-100 select2-hidden-accessible @error('parent_id') is-invalid @enderror" name="parent_id" data-width="100%" aria-hidden="true">
                    <option value=""​>--- Choose department ---</option>
                        @if ($department->parent)
                            @foreach ($departments as $id => $dep)
                                <option value="{{ $id }}"​ {{ old('parent_id', $department->parent->id ) ==  $id ? 'selected' : ''  }}>{{ $dep }}</option>
                            @endforeach
                        @else
                            @foreach ($departments as $id => $dep)
                                <option value="{{ $id }}"​>{{ $dep }}</option>
                            @endforeach
                        @endif
                </select>
                @error('parent_id')
                    <label class="error mt-2 text-danger">{{ $message }}</label>
                @enderror
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
@section('scripts')
@parent
{!! JsValidator::formRequest('App\Http\Requests\Department\UpdateDepartmentRequest') !!}
@endsection