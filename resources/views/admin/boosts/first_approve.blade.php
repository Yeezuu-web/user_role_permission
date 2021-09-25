@extends('layouts.admin')

@section('content')
@include('partials.flash-message')
<div class="card">
    <div class="card-header">
        {{ trans('cruds.boost.title_singular') }} Request First Approval
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <h5 class="mb-2">Client info</h5>
                <table class="table table-bordered table-striped table-hover">
                    <tbody>
                        <tr>
                            <td>Requester Name</td>
                            <td>{{ $boost->requester_name }}</td>
                        </tr>
                        <tr>
                            <td>Company Name</td>
                            <td>{{ $boost->company_name }}</td>
                        </tr>
                        <tr>
                            <td>Group</td>
                            <td>{{ $boost->group }}</td>
                        </tr>
                        <tr>
                            <td>Budget</td>
                            <td>$ {{ $boost->budget }}</td>
                        </tr>
                        <tr>
                            <td>Reference</td>
                            <td>
                                @if ($boost->reference)
                                    <img src="{{ $boost->reference->thumbnail}}" alt="reference">
                                @else
                                    no image...
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-6">
                <h5 class="mb-2">Boost info</h5>
                <table class="table table-bordered table-striped table-hover">
                    <tbody>
                        <tr>
                            <td>Product/Program Name</td>
                            <td>{{ $boost->program_name ?? ''}}</td>
                        </tr>
                        <tr>
                            <td>Target URL</td>
                            <td>{{ $boost->target_url ?? ''}}</td>
                        </tr>
                        <tr>
                            <td>Boost Start</td>
                            <td>{{ $boost->boost_start ?? ''}}</td>
                        </tr>
                        <tr>
                            <td>Target Channel</td>
                            <td style="padding: 3px 3px 3px 15px;">
                                @foreach ($boost->channels as $channel)
                                    <span class="badge badge-success badge-sm">{{ $channel->title }}</span>
                                @endforeach
                            </td>
                        </tr>
                        <tr>
                            <td>More Detail</td>
                            <td>{{ $boost->detail ?? ''}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-12 mt-3">
                <button class="btn btn-danger float-lg-right">Reject</button>
                <button class="btn btn-success mr-3 float-lg-right">Approve</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
@parent
@endsection
