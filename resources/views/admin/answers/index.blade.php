<!-- Admin Page -->
@extends('admin.layouts.app')

@section('content')
    <div class="row pt-3 pb-3">
        <div class="col-lg-12 text-left mb-3">
            <h1 class="m-0 p-0">Answers: </h1>
        </div>
        <div class="col-lg-12 mt-3 pt-3">
            <a href="{{ route('admin.answers.create') }}" class="btn btn-outline-danger text-right m-0 ">Create New</a>
        </div>
    </div>
    <!-- Users -->
    <div class="mt-3 mb-3">
        <table class="table table-sm">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">ID</th>
                <th scope="col">Content</th>
                <th scope="col">Is True?</th>
                <th scope="col">Question</th>
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
                        <span style="color: green;"> Yes </span>
                    @else
                        <span style="color: red;"> No </span>
                    @endif
                </td>
                <td>{{ $answer->question_id }}</td>
                <td>
                    <div class="w-100">
                        <div class="w-100 d-inline-flex">
                            <div>
                                <a href="{{ route('admin.answers.edit', $answer) }}">
                                    <button type="submit" class="btn btn-warning mr-1 btn-sm" title="delete">
                                        Edit
                                    </button>
                                </a>
                            </div>
                            <div style="width: 10px; height: 100%;"></div>
                            <div>
                                <form action="{{ route('admin.answers.destroy', $answer) }}" method="POST" class="m-0">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" title="delete" onclick="return confirm('Are you sure?');">
                                        Delete
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
