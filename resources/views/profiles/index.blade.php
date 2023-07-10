@extends('layouts.app')

@section('content')
    <div class="box-main">
        <div class="container">
            <div class="row pb-5">
                <div class="col-sm-3">
                    <img
                        src=" {{ asset($user->profile->getImage()) }}"
                        class="w-100 rounded-circle">
                </div>
                <div class="col-sm-9 pt-4">
                    <div class="container">
                        <div class="row ">
                            <div class="d-flex">
                                <h2 class="pr-3">{{ $user->username }}</h2>
                                @cannot('update',$user->profile)
                                    <follow-button user-id="{{ $user->id }}" follows="{{ $follows }}"></follow-button>
                                    <a href="{{ route('chat.index') }}"
                                       class="btn btn-primary ml-2" style="height: fit-content">{{__('Message')}}</a>
                                @endcan
                                @can('update',$user->profile)
                                    <a href="{{ route('profile.edit',['user' => $user->username]) }}"
                                       class="btn btn-primary"
                                       style="height: fit-content;"
                                       title="{{ __('Edit profile') }}">{{ __('Edit profile') }}</a>
                                @endcan
                            </div>


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
            </div>

            <div class="row justify-content-center w-100">
                <ul class="nav nav-tabs w-100 justify-content-center" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="pill" href="#POSTS">POSTS</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="pill" href="#FOLLOWERS">FOLLOWERS</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="pill" href="#FOLLOWING">FOLLOWING</a>
                    </li>
                </ul>
            </div>

            <div class="tab-content">
                <div class="tab-pane active" id="POSTS">
                    <div class="row">
                        @foreach($user->posts as $item)
                            <div class="col-4 p-1">
                                <a href="{{ route('post.show',['post' => $item->id]) }}">
                                    <img src="{{asset('/storage/'.$item->image)}}" class="w-100" alt="">
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="tab-pane fade" id="FOLLOWERS">
                    <div class="row p-5 flex-column align-content-center justify-content-center">
                        @foreach($usersFollowers as $userFollower)
                            <div class="d-flex justify-content-between mt-2 mb-3 w-100">
                                <div class="d-flex">
                                    <a class="mr-2"
                                       href="{{ route('profile.index',['user' => $userFollower->username]) }}"><img
                                            src="{{asset($userFollower->profile->getImage())}}" class="rounded-circle border"
                                            width="35"
                                            height="35" alt=""></a>
                                    <div class="d-flex flex-column">
                                        <a class="text-dark text-decoration-none"
                                           href="{{ route('profile.index',['user' => $userFollower->username]) }}"><strong>{{ $userFollower->username }}</strong></a>
                                        <small>{{$userFollower->name}}</small>
                                    </div>
                                </div>
                                @cannot('update',$userFollower->profile)
                                    <follow-button user-id="{{ $userFollower->id }}"
                                                   follows="{{ auth()->user()->following->contains($userFollower->id) }}"></follow-button>
                                @endcan

                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="tab-pane fade" id="FOLLOWING">
                    <div class="row p-5 flex-column align-content-center justify-content-center">
                        @foreach($usersFollowing as $userFollowing)
                            <div class="d-flex justify-content-between mt-2 mb-3 w-100">
                                <div class="d-flex">
                                    <a class="mr-2"
                                       href="{{ route('profile.index',['user' => $userFollowing->user->username]) }}"><img
                                            src="{{asset($userFollowing->getImage())}}" class="rounded-circle border"
                                            width="35"
                                            height="35" alt=""></a>
                                    <div class="d-flex flex-column">
                                        <a class="text-dark text-decoration-none"
                                           href="{{ route('profile.index',['user' => $userFollowing->user->username]) }}"><strong>{{ $userFollowing->user->username }}</strong></a>
                                        <small>{{$userFollowing->user->name}}</small>
                                    </div>
                                </div>
                                @cannot('update',$userFollowing)
                                    <follow-button user-id="{{ $userFollowing->user_id }}"
                                                   follows="{{ auth()->user()->following->contains($userFollowing->user_id) }}"></follow-button>
                                @endcan
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
