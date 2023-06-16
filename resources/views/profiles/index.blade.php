@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row pb-5 border-bottom">
            <div class="col-3">
                <img
                    src=" {{ $user->profile->getImage() }}"
                    class="p-3 w-100 rounded-circle">
            </div>
            <div class="col-9 pt-4">
                <div class="row justify-content-between">
                    <div class="d-flex">
                        <h1 class="pr-5">{{ $user->username }}</h1>
                        <follow-button user-id="{{ $user->id }}" follows="{{ $follows }}"></follow-button>
                    </div>
                    @can('update',$user->profile)
                        <a href="{{ route('post.create') }}" class="pb-2 pt-2">Add new post</a>
                    @endcan

                </div>
                <div class="row">
                    @can('update',$user->profile)
                    <a href="{{ route('profile.edit',['user' => $user->username]) }}">{{ __('Edit profile') }}</a>
                    @endcan
                </div>
                <div class="row pb-3">
                    <div class="pr-5"><strong>{{ $postsCount }}</strong> posts</div>
                    <div class="pr-5"><strong>{{ $followersCount }}</strong> followers</div>
                    <div class="pr-5"><strong>{{ $followingCount }}</strong> following</div>
                </div>
                <div class="row"><strong>{{ $user->profile->title }}</strong></div>
                <div class="row">{{ $user->profile->description }}</div>
                <div class="row"><a href="{{ url($user->profile->url ?? '#') }}">{{ $user->profile->url }}</a></div>
            </div>
        </div>

        <div class="row justify-content-center">
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="pill" href="#POSTS">POSTS</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="pill" href="#TAGGED">TAGGED</a>
                </li>
            </ul>
        </div>

        <div class="tab-content">
            <div class="tab-pane active" id="POSTS">
                <div class="row">
                    @foreach($user->posts as $item)
                        <div class="col-4 p-1">
                            <a href="{{ route('post.show',['post' => $item->id]) }}">
                                <img src="/storage/{{$item->image}}" class="w-100" alt="">
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="tab-pane fade" id="TAGGED">
                <div class="row p-5 align-content-center justify-content-center">
                    <h1>No Photos</h1>
                </div>
            </div>
        </div>


    </div>
@endsection
