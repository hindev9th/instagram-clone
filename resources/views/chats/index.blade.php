@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row clearfix">
            <div class="col-lg-12">
                <chat user="{{ auth()->user() }}" chats="{{ $chats }}"></chat>
            </div>
        </div>
    </div>
@endsection
