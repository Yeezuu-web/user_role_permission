@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h3>{{ $details['title'] }}</h3>
            <p>I am from {{ $details['company'] }}</p>
            <p>Currently, I have to ask a permission to boost some content.</p>
            <p>Please kindly, and approve</p> <br>
        </div>
        <div class="col-md-12">
            <a href="{{$details['link']}}" class="btn btn-success btn-lg">Check and Approve Now</a>
        </div>
    </div>
@endsection
