@extends('client.layouts.app')
<!-- -->

<?php
    if(isset($_GET['page'])){ $current_page = $_GET['page']; }
    else{ $current_page = '1'; }
?>

@section('content')
    <div class="row">
        <div class="col-lg-12">
            @for($i = 1; $i <= $pages; $i++)
                @if($i == $current_page)
                    <span style="color: red;">{{ $i }}</span>
                @else
                    <span style="color: gray;">{{ $i }}</span>
                @endif
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
                        <!-- перебираем все наши вопросы -->
                        @foreach($answers as $answer)
                            <!-- выписываем варианты ответов, которые относяться к этому вопросу -->
                            @if($answer->question_id == $question->id)
                                <input type="radio" id="{{ $answer->id }}" name="question_answer" value="{{ $answer->is_true }}">
                                <label for="{{ $answer->id }}">{{ $answer->content }}</label><br>
                            @endif
                        @endforeach
                        <input type="hidden" value="{{ $current_page }}" name="page">
                        <button class="btn btn-primary mt-4" type="submit" name="action">Ďalšia otázka</button>
                    </form>
                </div>
            @endforeach
        </div>
    </div>
@endsection
