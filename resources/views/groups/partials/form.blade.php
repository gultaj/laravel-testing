<form action="{{ route('groups.store') }}" method="POST">
    {{ csrf_field() }}
    <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
        <div class="input-group">
            <input type="text" class="form-control" name="title" placeholder="Type Title...">
            <span class="input-group-btn">
                <button class="btn btn-success" id="submit-group" type="submit"><i class="fa fa-plus"></i></button>
            </span>
        </div>
        @if ($errors->has('title'))
            <span class="help-block has-error"><strong>{{ $errors->first('title') }}</strong></span>
        @endif
    </div>
</form>