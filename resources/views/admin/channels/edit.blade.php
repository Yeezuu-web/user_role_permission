@extends('layouts.admin')

@section('content')
@include('partials.flash-message')
<div class="form-group">
    <a class="btn btn-secondary" href="{{ route('admin.channels.index') }}">
        {{ trans('global.back') }}
    </a>
</div>
<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.channel.title_singular') }}
    </div>
    <div class="card-body">
        <form action="{{ route('admin.channels.update', [$channel->id]) }}" method="POST" autocomplete="off">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="title">{{ trans('cruds.channel.fields.title') }}</label>
                <input class="form-control @error('title') form-control-danger @enderror" type="text" name="title" id="title"  value="{{ old('title', $channel->title) }}" required>
                @error('title')
                    <label id="title-error" class="error mt-2 text-danger" for="title">{{ $message }}</label>
                @enderror
            </div>
            <div class="form-group">
                <label for="description">{{ trans('cruds.channel.fields.description')}}</label>
                <textarea class="form-control" type="text" name="description" id="description" rows="9">{{ old('title', $channel->description) }}</textarea>
            </div>
            <div class="form-group">
                <button class="btn btn-primary" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
@parent
{!! JsValidator::formRequest('App\Http\Requests\Channel\UpdateChannelRequest') !!}
@endsection
