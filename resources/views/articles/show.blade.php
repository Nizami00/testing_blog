@extends('layouts.app')
@section('content')
    <div class="container">
        <a href="{{ route('articles.index') }}" class="btn btn-primary btn-sm">
            Back
        </a>
    <div class="card text-white bg-dark mb-3" style="max-width: 18rem;">
        <div class="card-header">{{$article->title}}</div>
        <div class="card-body">
            <h5 class="card-title">{{$article->content}}</h5>
        </div>
    </div>
    </div>
@endsection
