@extends('layouts.guest')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h3>{{ $details['title'] }}</h3>
            <p>You received Facebook Boosting Request from {{ $details['company'] }}</p>
            <p>for Brand {{ $details['brand'] }} @ amount USD {{ $details['budget']}}</p>
            <p>Please click the link below for detail information and {{ $details['action'] }}:</p> <br>
        </div>
        <div class="col-md-12">
            <p>To review:</p>
            <a href="{{$details['link']}}" class="btn btn-info">Click Here</a>
        </div>
        <div class="col-md-12">
            <p>Thanks and Regards,</p>
        </div>
    </div>
    
@endsection
