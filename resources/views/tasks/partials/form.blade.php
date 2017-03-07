<form action="{{ route('tasks.store', $group) }}" method="POST">
    {{ csrf_field() }}
    <div class="form-group{{ $errors->has('body') ? ' has-error' : '' }}">
        <div class="input-group">
            <input type="text" class="form-control" name="body" placeholder="Type Task...">
            <span class="input-group-btn">
                <button class="btn btn-success" id="submit-task" type="submit"><i class="fa fa-plus"></i></button>
            </span>
        </div>
        @if ($errors->has('body'))
            <span class="help-block has-error"><strong>{{ $errors->first('body') }}</strong></span>
        @endif
    </div>
</form>