<!-- Admin Page -->
@extends('admin.layouts.app')
@section('content')
    <!-- Edit Users -->
    <div class="row pt-3 pb-3">
        <div class="col-lg-12 text-left mb-3 mt-3">
            <h2 class="m-0 p-0">Create new user: </h2>
            <div>
                <a href="{{ route('admin.users.index') }}" class="text-secondary" style="text-decoration: none;"> <- Go back to users</a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="">
                <div class="">
                    <div>
                        @if($errors)
                            @foreach($errors->all() as $error)
                                <div class="alert alert-danger" role="alert">
                                    {{ $error }}
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <form method="post" action="{{route('admin.users.store')}}" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-2">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <div class="input-group">
                                        <input type="text" name="name" id="name" class="form-control validate @error('name') is-invalid @enderror" value="{{ old('name') }}" maxlength="255">
                                    </div>
                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback"><strong>{{ $errors->first('name') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="bmd-label-floating" for="email">Email</label>
                                    <div class="input-group">
                                        <input type="email" name="email" class="form-control validate @error('email') is-invalid @enderror" value="{{ old('email')  }}" required>
                                    </div>
                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback"><strong>{{ $errors->first('email') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="input-field col-md-6">
                                <label for="password" class="bmd-label-floating">Password</label>
                                <div class="input-group">
                                    <input type="password" name="password" id="password" class="form-control validate @error('password') is-invalid @enderror">
                                </div>
                                @if ($errors->has('password'))
                                    <span class="invalid-feedback"><strong>{{ $errors->first('password') }}</strong></span>
                                @endif
                                <span class="helper-text">{{--__('app.blankIfNoChange')--}}</span>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="input-field col-md-6">
                                <label for="password_repeat">Repeat Password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control validate" id="password_repeat">
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-primary mt-4" type="submit" name="action">Create User !</button>
                        <div class="clearfix"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--/ Edit Users /-->
@endsection
