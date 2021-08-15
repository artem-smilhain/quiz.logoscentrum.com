@extends('client.layouts.app')
<!-- -->
@section('content')
    <div class="row mt-3">
        <div class="col-lg-6 mt-3">
            <form action="{{ route('quiz.form.send_form') }}" method="post" class="mb-4">
                @csrf
                <div class="form-group mb-2">
                    <label for="name">Name:</label>
                    <input type="text" name="name" id="name" class="form-control" required>
                </div>
                <div class="form-group mb-2">
                    <label for="email">Email:</label>
                    <input type="email" name="email" id="email" class="form-control" required>
                </div>
                <div class="form-group mb-2">
                    <label for="phone">Phone</label>
                    <input type="text" name="phone" id="phone" class="form-control" required>
                </div>
                <div class="form-group mb-2">
                    <label for="consultation">Хочу консультацию</label>
                    <input type="checkbox" name="consultation" id="consultation">
                </div>
                <input type="hidden" name="rating" id="rating" value="{{ $rating }}">
                <button type="submit" class="btn btn-success">Send it</button>
            </form>
        </div>
    </div>
@endsection
