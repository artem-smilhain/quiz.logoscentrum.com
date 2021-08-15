@extends('client.layouts.app')
<!-- -->
<?php
    if(isset($_GET['page'])){ $current_page = $_GET['page']; }
    else{ $current_page = '1'; }
?>

@section('content')
    <div class="row">
        <div class="col-lg-12 mt-3">
            @for($i = 1; $i <= $pages; $i++)
                    <span>
                        <a href="/quiz?page={{ $i }}"
                           @if($i == $current_page)
                            style="color: #FAD108;"
                           @else
                            style="color: #666666;"
                           @endif
                        >
                            {{ $i }}
                        </a>
                    </span>
            @endfor
        </div>
    </div>
    <div class="row">
        <div class="mt-4">
            @foreach($questions as $question)
                {{ $question->content }}
                <div class="mt-3 mb-3">
                    <form method="post" action="{{route('quiz.session')}}" enctype="multipart/form-data">
                        @csrf
                        @foreach($question->answer as $answer)
                                <label for="{{ $answer->id }}" style="cursor: pointer;">
                                    <input type="radio" id="{{ $answer->id }}" name="question_answer" value="{{ $answer->is_true }}">
                                    <img src="/images/images/{{ $answer->image }}" alt="" style="max-height: 150px;">
                                    {{ $answer->content }}
                                </label>
                                <br><br>
                        @endforeach
                        <input type="hidden" value="{{ $current_page }}" name="page">
                        <button class="btn btn-warning mt-4" type="submit" name="action">Ďalšia otázka</button>
                    </form>
                </div>
            @endforeach
        </div>
    </div>
@endsection
