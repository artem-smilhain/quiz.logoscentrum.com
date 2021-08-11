@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <a href="/dashboard/questions">Questions</a>
                    <a href="/dashboard/answers">Answers</a>
                    <a href="/dashboard/clients">Clients</a>
                </div>
            </div>
        </div>
    </div>
</div>
@if (session('status'))
    <div class="alert alert-success" role="alert">
        {{ session('status') }}
    </div>
@endif
@endsection
