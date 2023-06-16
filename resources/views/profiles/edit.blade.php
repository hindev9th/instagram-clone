@extends('layouts.app')

@section('content')
    <div class="container">
            <form  action="{{ route('profile.update',['user' => $user->username]) }}" enctype="multipart/form-data" method="POST">
                @csrf
                @method('PATCH')

                <h1>{{ __('Edit profile') }}</h1>
                <div class="">
                    <label for="title" class="col-form-label">{{ __('Title') }}</label>

                    <input id="title" type="text" class="form-control @error('title') is-invalid @enderror"
                           name="title" value="{{ old('title') ?? $user->profile->title }}" required autocomplete="title" autofocus>

                    @error('title')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>
                <div class="">
                    <label for="description" class="col-form-label">{{ __('Description') }}</label>

                    <input id="description" type="text" class="form-control @error('description') is-invalid @enderror"
                           name="description" value="{{ old('description') ?? $user->profile->description }}" required autocomplete="description" autofocus>

                    @error('description')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>
                <div class="">
                    <label for="url" class="col-form-label">{{ __('URL') }}</label>

                    <input id="url" type="text" class="form-control @error('url') is-invalid @enderror"
                           name="url" value="{{ old('url') ?? $user->profile->url }}" required autocomplete="url" autofocus>

                    @error('url')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>
                <div class="">
                    <label for="image" class="col-form-label">{{ __('Profile image') }}</label>

                    <input id="image" type="file" class="form-control-file @error('image') is-invalid @enderror"
                           name="image" value="{{ old('image')  }}"  autocomplete="image">

                    @error('image')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>

                <div class=" pt-4">
                    <button class="btn btn-primary">Save profile</button>
                </div>
            </form>

    </div>
@endsection
