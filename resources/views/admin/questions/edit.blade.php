<!-- Admin Page -->
@extends('admin.layouts.app')
@section('content')
    <!-- Edit Users -->
    <div class="row pt-3 pb-3">
        <div class="col-lg-12 text-left mb-3 mt-3">
            <h2 class="m-0 p-0">Edit Question</h2>
            <div>
                <a href="{{ route('admin.questions.index') }}" class="text-secondary" style="text-decoration: none;"> <- Go back to questions</a>
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
                    <form method="post" action="{{route('admin.questions.update', $question)}}" enctype="multipart/form-data">

                        {{ csrf_field() }}
                        {{ method_field('patch') }}

                        <div class="row mb-2">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="content">Content</label>
                                    <div class="input-group">
                                        <input type="text" name="content" id="content" class="form-control validate @error('content') is-invalid @enderror" value="{{ old('content', $question->content)}}">
                                    </div>
                                    @if ($errors->has('content'))
                                        <span class="invalid-feedback"><strong>{{ $errors->first('content') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <button class="btn btn-primary mt-4" type="submit" name="action">Save question</button>
                        <div class="clearfix"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--/ Edit Users /-->
@endsection
