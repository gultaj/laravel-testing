@extends('layouts.app')

@section('content')
    <div class="container">
        @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong>Congratulation!</strong> {{ session()->get('success') }}
            </div>
        @endif
        <div class="row">
            <div class="col-md-4">
                <div class="panel panel-default" style="height: 100%">
                    <div class="panel-heading">Groups</div>

                    <div class="panel-body">

                        @include('groups.partials.list')

                        @include('groups.partials.form')

                    </div>
                </div>

            </div>
            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-heading">Tasks in group: {{ $group->title }}</div>

                    <div class="panel-body">

                        @include('tasks.partials.list', ['tasks' => $group->tasks, 'showGroup' => false])

                        @include('tasks.partials.form')

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection