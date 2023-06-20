@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-9 d-flex flex-column align-items-center">
                @foreach($posts as $post)
                    <div class="  pt-5 w-100">
                        <div class="row w-100 m-0 pb-2">
                            <div class="col-1 pr-1 pl-1">
                                <img src="{{ $post->user->profile->getImage() }}"
                                     class="w-100 rounded-circle img-thumbnail" alt="">
                            </div>
                            <div class="col-11 pl-2 d-flex align-items-center justify-content-between font-weight-bold">
                                <div class="d-flex align-items-center">
                                    <a href="{{ route('profile.index',['user' => $post->user->username]) }}"
                                       class="text-decoration-none text-dark pr-2"><strong>{{$post->user->username}}</strong></a>
                                    <i class="fas fa-circle pr-2" style="font-size: 5px"></i>
                                    <div class="font-weight-normal">{{formatDayAgo($post->created_at)}}</div>
                                </div>
                            </div>
                        </div>
                        <div class="border d-flex justify-content-center align-items-center">
                            <a href="{{ route('post.show',['post' => $post->id]) }}">
                                <img src="/storage/{{ $post->image }}" class="w-100" style="height: fit-content" alt="">
                            </a>
                        </div>
                        <div class="w-100 p-0 mh-100">
                            <div class="mw-100">
                                <div class="box-post w-100 pt-2">
                                    <div class="icon-button d-flex">
                                        <like-Button post-id="{{$post->id}}"
                                                     like="{{ (\auth()->user()) ? \auth()->user()->likes->contains($post->id) : false }}"></like-Button>
                                        <a href="{{ route('post.show',['post' => $post->id]) }}"><i
                                                class="far fa-comment ml-2" style="color: #212529; font-size: 25px"></i></a>
                                        <a href=""><i class="far fa-paper-plane ml-2"
                                                      style="color: #212529; font-size: 25px"></i></a>
                                    </div>
                                    <div class="info-post pt-2 d-flex flex-column">
                                        <strong>{{ formatNumber($post->likes->count()).' '.__('likes') }}</strong>
                                        <span>{{formatDayAgo($post->created_at)}}</span>
                                    </div>
                                    <div class="row m-0 pt-2 pb-2">
                                        <div class="w-100">
                                            <a href="{{ route('profile.index',['user' => $post->user->username]) }}"
                                               class="text-decoration-none text-dark"><strong>{{$post->user->username}}</strong></a>
                                            {{ $post->caption }}
                                        </div>
                                    </div>
                                    <a href="{{ route('post.show',['post' => $post->id]) }}"
                                       class="text-black-50 text-decoration-none">View
                                        all {{ $post->comments->count() }}
                                        comments</a>
                                    <div class="pb-3 border-bottom">
                                        <div class="pt-1 w-100">
                                            <form action="{{ route('comment.store', ['post' => $post->id]) }}"
                                                  method="post">
                                                @csrf

                                                <input id="user_id" type="hidden"
                                                       class="form-control border-0 @error('user_id') is-invalid @enderror"
                                                       name="user_id"
                                                       value="{{ \Illuminate\Support\Facades\Auth::user()->id }}"
                                                       autocomplete="user_id"
                                                       readonly>
                                                <div class="d-flex">
                                                    <input id="comment" type="text"
                                                           class="comment form-control border-0 p-0 @error('comment') is-invalid @enderror"
                                                           name="comment" value="{{ old('comment') }}" required
                                                           autocomplete="comment"
                                                           placeholder="{{ __('Add a comment') }}"
                                                           autofocus style="background-color: #f8fafc">

                                                    @error('comment')
                                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                                    @enderror

                                                    <button class="btn ">Post</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="remember col-md-3">
                <h3 class="mt-5">{{__('Suggested for you')}}</h3>
                @foreach($rememberUsers as $user)
                    <div class="d-flex justify-content-between mt-2 mb-3">
                        <div class="d-flex">
                            <a class="mr-2" href="{{ route('profile.index',['user' => $user->username]) }}"><img
                                    src="{{$user->profile->getImage()}}" class="rounded-circle border" width="35"
                                    height="35" alt=""></a>
                            <div class="d-flex flex-column">
                                <a class="text-dark text-decoration-none"
                                   href="{{ route('profile.index',['user' => $user->username]) }}"><strong>{{ $user->username }}</strong></a>
                                <span class="text-black-50" style="font-size: 10px">{{__('Suggested for you')}}</span>
                            </div>
                        </div>
                        <follow-button user-id="{{ $user->id }}"
                                       follows="{{ (auth()->user()) ? auth()->user()->following->contains($user->id) : false }}"></follow-button>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="row pt-5 pb-5">
            <div class="col-12 d-flex justify-content-center">
                {{ $posts->links() }}
            </div>
        </div>
    </div>

@endsection
