@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row clearfix">
            <div class="col-lg-12">
                <chat action="{{ url('/') }}" user="{{ auth()->user() }}" chats="{{ $chats }}"></chat>
            </div>
        </div>
    </div>
@endsection
