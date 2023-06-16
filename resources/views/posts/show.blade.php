@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row border" style="min-height: 450px;">
            <div class="col-6 border-right d-flex justify-content-center align-items-center">
                <img src="{{ $post->user->profile->getImage() }}" class="w-100" style="height: fit-content" alt="">
            </div>
            <div class="col-6 p-0 mh-100">
                <div class="row m-0 mw-100">
                    <div class="row w-100 m-0 border-bottom p-2">
                        <div class="col-1 pr-1 pl-1">
                            <img src="{{ $post->user->profile->getImage() }}" class="w-100 rounded-circle img-thumbnail"
                                 alt="">
                        </div>
                        <div class="col-11 pl-2 d-flex align-items-center font-weight-bold">
                            <a href="{{ route('profile.index',['user' => $post->user->username]) }}"
                               class="text-decoration-none text-dark pr-2"><strong>{{$post->user->username}}</strong></a>
                            <a href="" class="text-decoration-none pl-2">{{__('Follow')}}</a>
                        </div>
                    </div>
                    <div class="row m-0 p-2 overflow-auto mh-100 position-absolute flex-column flex-nowrap"
                         style="top: 55px; height: calc(100% - 104px);">
                        <div class="row m-0">
                            <div class="col-1 pr-1 pl-1">
                                <img src="{{ $post->user->profile->getImage() }}"
                                     class="w-100 rounded-circle img-thumbnail" alt="">
                            </div>
                            <div class="col-11 pl-2">
                                <a href="{{ route('profile.index',['user' => $post->user->username]) }}"
                                   class="text-decoration-none text-dark"><strong>{{$post->user->username}}</strong></a>
                                {{ $post->caption }}
                            </div>
                        </div>
                        @foreach($post->comments as $comment)
                            <div class="row m-0">
                                <div class="col-1 p-1">
                                    <img src="{{ $comment->user->profile->getImage() }}"
                                         class="w-100 rounded-circle img-thumbnail" alt="">
                                </div>
                                <div class="col-11 pl-2">
                                    <a href="{{ route('profile.index',['user' => $comment->user->username]) }}"
                                       class="text-decoration-none text-dark"><strong>{{$comment->user->username}}</strong></a>
                                    {{ $comment->comment }}
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="row m-0 border-top position-absolute fixed-bottom">
                        <div class="border-top w-100">
                            <form action="{{ route('comment.store', ['post' => $post->id]) }}" method="post">
                                @csrf

                                <input id="user_id" type="hidden"
                                       class="form-control border-0 @error('user_id') is-invalid @enderror"
                                       name="user_id" value="{{ \Illuminate\Support\Facades\Auth::user()->id }}"
                                       autocomplete="user_id"
                                       readonly>
                                <div class="d-flex">
                                    <input id="comment" type="text"
                                           class="form-control border-0 @error('comment') is-invalid @enderror"
                                           name="comment" value="{{ old('comment') }}" required autocomplete="comment"
                                           autofocus>

                                    @error('comment')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror

                                    <button class="btn">Send</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
