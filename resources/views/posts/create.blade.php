@extends('layouts.app')

@section('content')
    <div class="container">
            <form  action="{{ route('post.store') }}" enctype="multipart/form-data" method="POST">
                @csrf

                <h1>{{ __('Add new post') }}</h1>
                <div class="">
                    <label for="caption" class="col-form-label">{{ __('Caption') }}</label>

                    <input id="caption" type="text" class="form-control @error('caption') is-invalid @enderror"
                           name="caption" value="{{ old('caption') }}" required autocomplete="caption" autofocus>

                    @error('caption')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>
                <div class="">
                    <label for="image" class="col-form-label">{{ __('Post image') }}</label>

                    <input id="image" type="file" class="form-control-file @error('image') is-invalid @enderror"
                           name="image" value="{{ old('image') }}" required autocomplete="image">

                    @error('image')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>

                <div class=" pt-4">
                    <button class="btn btn-primary">Add new post</button>
                </div>
            </form>

    </div>
@endsection
