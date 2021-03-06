@extends('layouts.admin')
@section('styles')
    <style>
        .table td img {
            width: 80px;
            height: 80px;
            border-radius: 0%;
        }
    </style>
@endsection
@section('content')
@include('partials.flash-message')
<div class="card">
    <div class="card-header">
        {{ trans('cruds.boost.title_singular') }} Request Second Approval
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
                                    <a href="{{ $boost->reference->preview}}" target="_blank" rel="noopener noreferrer">
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
                        <tr>
                            <td>Reviewed By</td>
                            <td>{{ $boost->user->name ?? ''}}</td>
                        </tr>
                        <tr>
                            <td>Reviewed At</td>
                            <td>{{ $boost->reviewed_at ?? ''}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-12 mt-3">
                @csrf
                @if ($boost->status == '0' || $boost->status == '1')
                    <button type="button" class="btn btn-danger float-lg-right btn-load" onclick="reject({{ $boost->id }}, 'reject')">
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" hidden></span>
                        Reject
                    </button>
                    <button type="button" class="btn btn-success mr-3 float-lg-right btn-load" onclick="approve({{ $boost->id }}, 'approve')">
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" hidden></span>
                        Approve
                    </button>
                @else
                    <button type="button" class="btn btn-secondary float-lg-right" disabled>
                        Approved
                    </button>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
@parent
<script>
    $(document).ready(function () {
        $('.btn-load').children().hide();
    });

    approve = (id, action) => {
        let _token = $('input[name="_token"]').val();

        $.ajax({
            type: "POST",
            url: "/admin/boosts/secondApprove/update/" + id,
            data: {
                _token: _token,
                action: action,
                id: id
            },
            beforeSend: () => {
                $('.btn-load').children().show();
                $('.btn-load').attr('disabled', 'true');
            },
            success: function (response) {
                if(response == 'success'){
                    Swal.fire({
                        title: 'Approved',
                        text: "The request has been approved.",
                        icon: 'success',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Done'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            location.href = "/admin/boosts";
                        }
                    })
                }
                if(response == 'Opss') {
                    Swal.fire(
                        response,
                        'Something on occure',
                        'error'
                    );
                    $('.btn-load').children().hide();
                    $('.btn-load').removeAttr('disabled');
                }
            },
            complete: () => {
                $('.btn-load').children().hide();
                $('.btn-load').removeAttr('disabled');
            }
        });
    }

    reject = (id, action) => {
        let _token = $('input[name="_token"]').val();

        $.ajax({
            type: "POST",
            url: "/admin/boosts/secondApprove/update/" + id,
            data: {
                _token: _token,
                action: action,
                id: id
            },
            beforeSend: () => {
                $('.btn-load').children().show();
                $('.btn-load').attr('disabled', 'true');
            },
            success: function (response) {
                if(response == 'success'){
                    Swal.fire({
                        title: 'Rejected',
                        text: "The request has been rejected.",
                        icon: 'warning',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            location.href = "/admin/boosts";
                        }
                    })
                }
                if(response == 'Opss') {
                    Swal.fire(
                        response,
                        'Something on occure',
                        'error'
                    );
                    $('.btn-load').children().hide();
                    $('.btn-load').removeAttr('disabled');
                }
            },
            complete: () => {
                $('.btn-load').children().hide();
                $('.btn-load').removeAttr('disabled');
            }
        });
    }
</script>
@endsection
