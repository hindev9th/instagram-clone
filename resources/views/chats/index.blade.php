@extends('layouts.app')

@section('content')
    <div class="box-main chat-main">
        <div class="clearfix">
            <chat user="{{ auth()->user() }}" chats="{{ $chats }}"></chat>
        </div>
    </div>

@endsection
