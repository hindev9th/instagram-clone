@extends('layouts.app')

@section('content')
    <div class="box-main">
        <div class="container">
            <div class="row border w-100" style="min-height: 450px;"  >
                <div class="w-50 border-right d-flex justify-content-center align-items-center">
                    <img src="{{asset('/storage/'.$post->image)  }}" class="w-100" style="height: fit-content" alt="">
                </div>
                <div class="col-6 p-0 mh-100">
                    <div class="d-flex flex-column mw-100">
                        <div class="d-flex border-bottom position-relative">
                            <div class="box-user d-flex w-100">
                                <div class="pr-1 pl-2">
                                    <img src="{{ asset($post->user->profile->getImage()) }}" class="avatar rounded-circle"
                                         alt="">
                                </div>
                                <div class="col-11 pl-2 d-flex align-items-center font-weight-bold">
                                    <a href="{{ route('profile.index',['user' => $post->user->username]) }}"
                                       class="text-decoration-none text-dark pr-2"><strong>{{$post->user->username}}</strong></a>
                                </div>
                            </div>
                            <setting-button post="{{ $post }}" text-link="{{ route('post.show',['post'=> $post->id]) }}" profile-link="{{route('profile.index',['user' => Auth::user()->username])}}"></setting-button>
                        </div>
                        <div class="d-flex w-100 p-2 overflow-auto mh-100 position-absolute flex-column flex-nowrap"
                             style="top: 55px; height: calc(100% - 210px);">
                            <div class="d-flex mb-2">
                                <div class="pr-1">
                                    <img src="{{ asset($post->user->profile->getImage()) }}"
                                         class="avatar rounded-circle" alt="">
                                </div>
                                <div class="pl-2">
                                    <a href="{{ route('profile.index',['user' => $post->user->username]) }}"
                                       class="text-decoration-none text-dark"><strong>{{$post->user->username}}</strong></a>
                                    {{ $post->caption }}
                                    <div class="time">
                                        {{ formatDayAgo($post->created_at) }}
                                    </div>
                                </div>
                            </div>
                            @foreach($post->comments as $comment)
                                <div class="d-flex mt-2 mb-2">
                                    <div class="pr-1">
                                        <img src="{{ asset($comment->user->profile->getImage()) }}"
                                             class="avatar rounded-circle" alt="">
                                    </div>
                                    <div class="pl-2">
                                        <a href="{{ route('profile.index',['user' => $comment->user->username]) }}"
                                           class="text-decoration-none text-dark"><strong>{{$comment->user->username}}</strong></a>
                                        {{ $comment->comment }}
                                        <div class="time">
                                            {{ formatDayAgo($comment->created_at) }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="row w-100 m-0 border-top position-absolute" style="bottom: 0;left: 0;">
                            <div class="box-post p-2 w-100 bg-white">
                                <div class="icon-button d-flex">
                                    <like-Button post-id="{{$post->id}}" like="{{ $like }}"></like-Button>
                                    <a href="#comment"><i class="far fa-comment ml-2" style="color: #212529; font-size: 25px"></i></a>
                                    <share-button text-link="{{ route('post.show',['post' => $post->id]) }}"></share-button>
                                </div>
                                <div class="info-post pt-2 d-flex flex-column">
                                    <strong>{{ formatNumber($post->likes->count()).' '.__('likes') }}</strong>
                                    <span>{{formatDayAgo($post->created_at)}}</span>
                                </div>
                            </div>

                            <div class="border-top pt-3 w-100 bg-white">
                                <form action="{{ route('comment.store', ['post' => $post->id]) }}" method="post">
                                    @csrf

                                    <input id="user_id" type="hidden"
                                           class="form-control border-0 @error('user_id') is-invalid @enderror"
                                           name="user_id" value="{{ \Illuminate\Support\Facades\Auth::user()->id }}"
                                           autocomplete="user_id"
                                           readonly>
                                    <div class="d-flex">
                                        <input id="comment" type="text"
                                               class="comment form-control border-0 pl-2 @error('comment') is-invalid @enderror"
                                               name="comment" value="{{ old('comment') }}" required autocomplete="comment"
                                               placeholder="{{ __('Add a comment') }}"
                                               autofocus >

                                        @error('comment')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror

                                        <button class="btn ">{{__('Post')}}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
