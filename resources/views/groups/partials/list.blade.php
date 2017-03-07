<ul class="list-group">
    @foreach($groups as $group)
        <a href="{{ route('groups.show', $group) }}" class="list-group-item{{ request()->is('groups/' . $group->id) ? ' active' : '' }}">
            @if ($group->tasks_count)
                <span class="badge">{{ $group->tasks_count }}</span>
            @endif
            {{ $group->title }}
        </a>
    @endforeach
</ul>