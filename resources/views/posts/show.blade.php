@extends('layouts.app')

@section('content')
    <div class="box-main">
        <post-show user="{{Auth::user()}}" post="{{$post}}"></post-show>
    </div>
@endsection
