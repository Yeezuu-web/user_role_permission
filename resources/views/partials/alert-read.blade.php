@extends('layouts.admin')
@section('content')
<div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
    <div>
      <h4 class="mb-3 mb-md-0">User Alert</h4>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="card-title">Alert List</div>

        @if(count($alerts = \Auth::user()->userUserAlerts()->withPivot('read')->limit(10)->orderBy('created_at', 'ASC')->get()->reverse()) > 0)
            <ul class="list-group">
                @foreach($alerts as $alert)
                    <li class="list-group-item">
                        <a href="{{ $alert->alert_link ? $alert->alert_link : "#" }}" target="_blank" rel="noopener noreferrer">
                            @if($alert->pivot->read === 0) <strong> @endif
                                {{ $alert->alert_text }}
                            @if($alert->pivot->read === 0) </strong> @endif
                        </a>
                    </li>
                @endforeach
            </ul>
        @else
            <div class="text-center">
                {{ trans('global.no_alerts') }}
            </div>
        @endif
    </div>
</div>
@endsection
