@extends('layouts.app')

@section('content')
    <div class="box-main">
        <div class="container">
            <div class="row pb-5 border-bottom">
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
                                    <follow-button user-id="{{ $user->id }}" follows="{{ $follows }}" class="btn-primary text-right"></follow-button>
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
                            <div class="pr-5 d-flex"><strong>{{ $followersCount }}</strong> &nbsp
                                <show-user-button action="{{ route('follow.followers',['user'=> $user->id]) }}"
                                                  title="{{__('followers')}}"
                                                  text="{{__('followers')}}"></show-user-button>
                            </div>
                            <div class="pr-5 d-flex"><strong>{{ $followingCount }}</strong> &nbsp
                                <show-user-button action="{{ route('follow.following',['user'=> $user->id]) }}"
                                                  title="{{__('following')}}"
                                                  text="{{__('following')}}"></show-user-button>
                            </div>
                        </div>
                        <div class="row"><strong>{{ $user->profile->title }}</strong></div>
                        <div class="row">{{ $user->profile->description }}</div>
                        <div class="row"><a href="{{ url($user->profile->url ?? '#') }}">{{ $user->profile->url }}</a></div>
                    </div>
                </div>
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
            </div>
        </div>
    </div>
@endsection
