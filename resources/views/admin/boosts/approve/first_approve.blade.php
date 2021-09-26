@extends('layouts.admin')
@section('styles')
    <style>
        .table td img {
            width: 64px;
            height: 64px;
        }
        .swal2-success-circular-line-right {
            background-color: var(--theme-primary);
        }
        .swal2-success-circular-line-left {
            background-color: var(--theme-primary);
        }
    </style>
@endsection
@section('content')
@include('partials.flash-message')
<div class="card">
    <div class="card-header">
        {{ trans('cruds.boost.title_singular') }} Request First Approval
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-5">
                <h5 class="mb-2">Client info</h5>
                <table class="table table-bordered table-striped">
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
                                    <a href="{{ $boost->reference->preview}}" target="_blank">
                                        <img src="{{ $boost->reference->thumbnail}}" alt="reference">
                                    </a>
                                @else
                                    no image...
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-7">
                <h5 class="mb-2">Boost info</h5>
                <table class="table table-bordered table-striped table-hover">
                    <tbody>
                        <tr>
                            <td width="30">Product/Program Name</td>
                            <td>{{ $boost->program_name ?? ''}}</td>
                        </tr>
                        <tr>
                            <td width="30">Target URL</td>
                            <td>{{ $boost->target_url ?? ''}}</td>
                        </tr>
                        <tr>
                            <td width="30">Boost Start</td>
                            <td>{{ $boost->boost_start ?? ''}}</td>
                        </tr>
                        <tr>
                            <td width="30">Target Channel</td>
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
                @csrf
                <button type="button" class="btn btn-danger float-lg-right" id="btn-reject" onclick="btnReject({{ $boost->id }}, 'reject')">
                    Reject
                </button>
                <button type="button" class="btn btn-success mr-3 float-lg-right" id="btn-approve" onclick="btnApprove({{ $boost->id }}, 'approve')">
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    Approve
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
@parent
<script>
$(document).ready(() => {
    let spiner = $('#btn-approve').children();
    spiner.hide();
});

function btnApprove(id, action) {
    let _token = $('input[name="_token"]').val();

    $.ajax({
        type: "POST",
        url: "/admin/boosts/firstApprove/update/"+id,
        data: {
            _token: _token,
            action: action,
            id: id
        },
        beforeSend: () => {
            let spiner = $('#btn-approve').children();
            spiner.show();
            spiner.closest('#btn-approve').attr('disabled', 'true');
        },
        success: (response) => {
            if(response == 'success'){
                Swal.fire(
                    'Approved',
                    'You have approved',
                    'success'
                ).then(
                    setInterval(function(){ window.location.href = '/admin/boosts'; }, 1800)
                );
            }
            
            if(response == 'Opps'){
                let spiner = $('#btn-approve').children();
                spiner.hide();
                spiner.closest('#btn-approve').removeAttr('disabled');

                Swal.fire(
                    response,
                    'Something went wrong',
                    'warning'
                );
            }
        },
        complete: () => {
            let spiner = $('#btn-approve').children();
            spiner.hide();
            spiner.closest('#btn-approve').removeAttr('disabled');
        },
    });
};

function btnReject(id, action) {
    let _token = $('input[name="_token"]').val();

    $.ajax({
        type: "POST",
        url: "/admin/boosts/firstApprove/update/"+id,
        data: {
            _token: _token,
            action: action,
            id: id
        },
        beforeSend: () => {
            let spiner = $('#btn-reject').children();
            spiner.show();
            spiner.closest('#btn-reject').attr('disabled', 'true');
        },
        success: (response) => {
            if(response == 'success'){
                Swal.fire(
                    'Rejected!',
                    'You have rejectd.',
                    'error'
                ).then(
                    setInterval(function(){ window.location.href = '/admin/boosts'; }, 1800)
                );
            }

            if(response == 'Opps'){
                let spiner = $('#btn-reject').children();
                spiner.hide();
                spiner.closest('#btn-reject').removeAttr('disabled');

                Swal.fire(
                    response,
                    'Something went wrong',
                    'warning'
                );
            }
        },
        complete: () => {
            let spiner = $('#btn-reject').children();
            spiner.hide();
            spiner.closest('#btn-reject').removeAttr('disabled');
        },
    });
};
</script>
@endsection
