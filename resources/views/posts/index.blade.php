@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex flex-column align-items-center">
            @foreach($posts as $post)
                <div class="pb-5 pt-5 w-50 border-bottom">
                    <div class="row w-100 m-0 pb-2">
                        <div class="col-1 pr-1 pl-1">
                            <img src="{{ $post->user->profile->getImage() }}"
                                 class="w-100 rounded-circle img-thumbnail" alt="">
                        </div>
                        <div class="col-11 pl-2 d-flex align-items-center justify-content-between font-weight-bold">
                            <div class="d-flex">
                                <a href="{{ route('profile.index',['user' => $post->user->id]) }}"
                                   class="text-decoration-none text-dark pr-2"><strong>{{$post->user->username}}</strong></a>
                                <div class="font-weight-normal">{{ $post->created_at }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="border d-flex justify-content-center align-items-center">
                        <img src="/storage/{{ $post->image }}" class="w-100" style="height: fit-content" alt="">
                    </div>
                    <div class="w-100 p-0 mh-100">
                        <div class="mw-100">
                            <div class="row m-0">
                                <div class="w-100">
                                    <a href="{{ route('profile.index',['user' => $post->user->id]) }}"
                                       class="text-decoration-none text-dark"><strong>{{$post->user->username}}</strong></a>
                                    {{ $post->caption }}
                                </div>
                            </div>
                            <div class="">
                                a
                                <div class=" w-100">
                                    <form action="#">
                                        @csrf

                                        <div class="d-flex">
                                            <input id="comment" type="text"
                                                   class="form-control @error('comment') is-invalid @enderror"
                                                   name="comment" value="{{ old('comment') }}" required
                                                   placeholder="Add comment"
                                                   autocomplete="comment" autofocus>

                                            @error('comment')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror

                                            <button class="btn btn-primary">Send</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="row pt-5 pb-5">
            <div class="col-12 d-flex justify-content-center">
                {{ $posts->links() }}
            </div>
        </div>
    </div>

@endsection
