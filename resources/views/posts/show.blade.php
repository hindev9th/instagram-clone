@extends('layouts.app')

@section('content')
    <div class="box-main">
        <post-show user="{{Auth::user()}}" post-id="{{$postId}}"></post-show>
    </div>
@endsection
