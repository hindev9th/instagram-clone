@extends('layouts.app')

@section('content')
    <div class="container border shadow-sm" style="border-radius: 15px;height: 75vh;">
            <form  action="{{ route('post.store') }}" class="h-100" enctype="multipart/form-data" method="POST">
                @csrf

                <div class="title d-flex justify-content-between align-items-center pt-1 pb-1 border-bottom">
                    <a href="{{ url()->previous() }}" class="text-danger text-decoration-none"><strong>{{ __('Back') }}</strong></a>
                    <strong>{{ __('Add new post') }}</strong>
                    <button class="btn text-primary font-weight-bold">{{__('Share')}}</button>
                </div>
                <div class="box-new-post row h-100">
                    <div class="col-md-8 d-flex align-items-center justify-content-center border-right">
                        <label for="image" class="col-form-label custom-file-image-label"></label>

                        <input id="image" type="file" class="form-control-file @error('image') is-invalid @enderror"
                               name="image" value="{{ old('image') }}" required autocomplete="image">
                        @error('image')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <div class="box-user pt-2 pb-2">
                            <img src="{{ Auth::user()->profile->getImage() }}" class="rounded-circle border" width="35px" alt="">
                            <strong>{{ Auth::user()->username }}</strong>
                        </div>
                        <textarea id="caption" type="text" class="form-control p-0 border-0 bg-transparent @error('caption') is-invalid @enderror"
                                  rows="10"
                                  name="caption"
                                  value="{{ old('caption') }}"
                                  required
                                  autocomplete="caption"
                                  placeholder="{{__('Write a caption...')}}"

                                  autofocus></textarea>

                        @error('caption')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>

                </div>
            </form>

    </div>
@endsection
