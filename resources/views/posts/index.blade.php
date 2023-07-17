@extends('layouts.app')

@section('content')
    <div class="box-main">
        <div class="post-home container">
            <div class="box-post d-flex justify-content-around w-100">
                <posts-list posts="{{ $posts[1] }}" user="{{json_encode(Auth::user()) }}"></posts-list>
                <div class="remember col-md-4">
                    <div class="box-user align-items-center justify-content-between" style="border-radius: 0.7rem;">
                        <div class="box-info d-flex align-items-center">
                            <div
                                class="avatar">
                                <a href="{{ route('profile.index',['user' => Auth::user()->username]) }}">
                                    <img src="{{ Auth::user()->profile->getImage() }}" alt="" class=" " style="left: -5px">
                                </a>
                            </div>
                            <div class="box-name d-flex flex-column">
                                <a href="{{ route('profile.index',['user' => Auth::user()->username]) }}" class="text-dark text-decoration-none username">
                                    <strong class="username">{{ Auth::user()->username }}</strong>
                                </a>
                                <span class="name">{{ auth()->user()->name }}</span>
                            </div>
                        </div>
                        <div class="logout pl-2 pr-2">
                            <a href="{{ route('logout') }}"
                               onclick="event.preventDefault();document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </div>
                    <h3 class="mt-2">{{__('Suggested for you')}}</h3>
                    <div class="suggested-users">
                        @foreach($rememberUsers as $user)
                            <div class="user  mt-2 mb-3">
                                <div class="info d-flex">
                                    <div class="avatar">
                                        <a class="mr-2" href="{{ route('profile.index',['user' => $user->username]) }}"><img
                                                src="{{asset($user->profile->getImage())}}" alt=""></a>
                                    </div>
                                    <div class="name d-flex flex-column">
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
            </div>
            <div class="row pt-5 pb-5">
                <div class="col-12 d-flex justify-content-center">
                    {{ $posts->links() }}
                </div>
            </div>
        </div>
    </div>

@endsection
