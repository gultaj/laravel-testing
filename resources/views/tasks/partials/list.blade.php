@if ($tasks->count())
    <ul class="tasks">
        @foreach($tasks as $task)
            <li class="{{ $task->completed ? 'completed' : '' }}">
                <form action="{{ route('tasks.toggle', [$task->group, $task]) }}" method="post" style="display: inline; vertical-align: middle">
                    {{ csrf_field() }}
                    {{ method_field('patch') }}
                    <input type="checkbox" name="completed" id="completed-{{ $task->id }}" {{ $task->completed ? 'checked="checked' : '' }} onchange="this.form.submit()">
                    <input type="submit" class="hidden" name="toggle-task-{{ $task->id }}" value="Toggle completed">
                </form>&nbsp;
                <span>{{ $task->body }}</span> @if ($showGroup) ({{ $task->group->title }}) @endif
                <div class="controls pull-right">
                    <a href="{{ route('tasks.edit', [$task->group, $task]) }}" id="update-task-{{ $task->id }}" class="btn btn-default btn-xs">
                        <i class="fa fa-pencil"></i>
                    </a>
                    <form action="{{ route('tasks.destroy', [$task->group, $task]) }}" style="display: inline;" method="post">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                        <button type="submit" id="destroy-task-{{ $task->id }}" class="btn btn-default btn-xs"><i class="fa fa-times"></i></button>
                    </form>
                </div>
            </li>
        @endforeach
    </ul>
@else
    <p>No tasks</p>
@endif
