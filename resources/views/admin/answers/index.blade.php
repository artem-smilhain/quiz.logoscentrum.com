<!-- Admin Page -->
@extends('admin.layouts.app')

@section('content')
    <div class="row pt-3">
        <div class="col-lg-6 text-left">
            <h1 class="m-0 p-0">Варианты ответов: </h1>
        </div>
        <div class="col-lg-6 text-right">
            <div style="float: right; align-items: center;" class="d-flex h-100">
                <a href="{{ route('admin.answers.create') }}" class="btn btn-warning text-right m-0 ">Добавить ответ</a>
            </div>
            <div style="clear: right;"></div>
        </div>
    </div>
    <div class="mt-3 mb-3">
        <table class="table table-sm">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">ID</th>
                <th scope="col">Содержимое ответа</th>
                <th scope="col">Значение</th>
                <th scope="col">ID вопроса</th>
                <th scope="col">Действие</th>
            </tr>
            </thead>
            <tbody>
            <?php $count = 1 ?>
            @foreach($answers as $answer)
            <tr>
                <th scope="row">{{ $count }}</th>
                <td>{{ $answer->id }}</td>
                <td>{{ $answer->content }}</td>
                <td>
                    @if($answer->is_true == 1)
                        <span style="color: green;"><b>+</b></span>
                    @else
                        <span style="color: red;"><b>-</b></span>
                    @endif
                </td>
                <td>{{ $answer->question_id }}</td>
                <td>
                    <div class="w-100">
                        <div class="w-100 d-inline-flex">
                            <div>
                                <a href="{{ route('admin.answers.edit', $answer) }}">
                                    <button type="submit" class="btn btn-outline-secondary mr-1 btn-sm btn-hjk" title="delete">
                                        Редактировать
                                    </button>
                                </a>
                            </div>
                            <div style="width: 10px; height: 100%;"></div>
                            <div>
                                <form action="{{ route('admin.answers.destroy', $answer) }}" method="POST" class="m-0">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm btn-hjk" title="delete" onclick="return confirm('Are you sure?');">
                                        Удалить
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
                <?php $count++; ?>
            @endforeach
            </tbody>
        </table>
    </div>
    <!--/ Users -->
@endsection
