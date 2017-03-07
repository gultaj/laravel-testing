<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = ['title'];

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tasksCount()
    {
        return $this->tasks()->selectRaw('group_id, count(*) as count')->groupBy('group_id');
    }

    public function getTasksCountAttribute()
    {
        if (! $this->relationLoaded('tasksCount')) $this->load('tasksCount');
        $related = $this->getRelation('tasksCount')->first();

        return $related ? (int) $related->count : 0;
    }

}
