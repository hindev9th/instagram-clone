@extends('layouts.app')

@section('content')
    <div class="box-main">
        <div class="post-home container">
            <div class="box-post d-flex justify-content-around w-100">
                <posts-list user="{{Auth::user()}}"></posts-list>
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
                    <div class="title-sug-user d-flex justify-content-between">
                        <span class="mt-2">{{__('Suggested for you')}}</span>
                        <show-user-button action="{{route('user.index')}}" title="{{__('Suggested for you')}}" text="{{__('See All')}}"></show-user-button>
                    </div>
                    <sug-users></sug-users>
                </div>
            </div>
        </div>
    </div>
@endsection
