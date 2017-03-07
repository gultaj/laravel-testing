@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Topics</div>

                    <div class="panel-body">
                        @foreach($topics as $topic)
                            <div class="media topic">
                                <div class="media-body">
                                    <h4 class="media-heading">{{ $topic->title }}</h4>
                                    <p>by {{ $topic->user->name }} {{ $topic->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
