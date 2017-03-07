@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Edit task: {{ $task->body }}</div>

                    <div class="panel-body">
                        <form action="{{ route('tasks.update', [$task->group, $task]) }}" method="post" class="form-horizontal">
                            {{ csrf_field() }}
                            {{ method_field('PATCH') }}
                            <div class="form-group{{ $errors->has('body') ? ' has-error' : '' }}">
                                <label for="body" class="col-md-4 control-label">Task</label>
                                <div class="col-md-6">
                                    <input id="body" type="" class="form-control" name="body" value="{{ $task->body or old('body') }}" required>
                                    @if ($errors->has('body'))
                                        <span class="help-block"><strong>{{ $errors->first('body') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-8 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">Save task</button>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>

            </div>
        </div>
    </div>
@endsection
