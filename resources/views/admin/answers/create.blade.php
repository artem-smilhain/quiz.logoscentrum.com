<!-- Admin Page -->
@extends('admin.layouts.app')
@section('content')
    <!-- Edit Users -->
    <div class="row pt-3 pb-3">
        <div class="col-lg-12">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 text-left mb-3 mt-3">
                        <h2 class="m-0 p-0">Создать ответ: </h2>
                        <div>
                            <a href="{{ route('admin.answers.index') }}" class="text-secondary" style="text-decoration: none;"> ◄ Вернуться обратно</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
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
                                <form method="post" action="{{route('admin.answers.store')}}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <label for="content">Содержимое:</label>
                                        <div class="input-group">
                                            <input type="text" name="content" id="content" class="form-control validate @error('content') is-invalid @enderror" value="{{ old('content') }}">
                                        </div>
                                        @if ($errors->has('content'))
                                            <span class="invalid-feedback"><strong>{{ $errors->first('content') }}</strong></span>
                                        @endif
                                    </div>
                                    <!-- -->
                                    <div class="form-group mt-3">
                                        <label for="is_true">Это правильный ответ?</label>
                                        <select id="is_true" name="is_true" class="form-select @error('is_true') is-invalid @enderror" required>
                                            <option value="1"> Yes </option>
                                            <option value="0"> No </option>
                                        </select>
                                        @error('is_true')
                                        <span class="invalid-feedback"><strong>{{ $errors->first('is_true') }}</strong></span>
                                        @enderror
                                    </div>
                                    <!-- -->
                                    <div class="form-group mt-3">
                                        <label for="question_id">К какому вопросу относится?</label>
                                        <select id="question_id" name="question_id" class="form-select @error('question_id') is-invalid @enderror" required>
                                            <option>Select Question</option>
                                            @foreach($questions as $question)
                                                <option value="{{ $question->id }}" {{ $question->id == old('question_id') ? 'selected' : '' }}>{{ $question->content }}</option>
                                            @endforeach
                                        </select>
                                        @error('question_id')
                                        <span class="invalid-feedback"><strong>{{ $errors->first('question_id') }}</strong></span>
                                        @enderror
                                    </div>
                                    <div class="form-group mt-3">
                                        <label for="image">Выбрать изоброжение (max 1000x1000):</label>
                                        <input type="file" name="image" class="form-control" value="{{ old('image') }}">
                                        @if ($errors->has('image'))
                                            <span class="invalid-feedback"><strong>{{ $errors->first('content') }}</strong></span>
                                        @endif
                                    </div>
                                    <!--</div>
                                </div>-->
                                    <button class="btn btn-warning mt-4" type="submit" name="action">Создать ответ</button>
                                    <div class="clearfix"></div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
