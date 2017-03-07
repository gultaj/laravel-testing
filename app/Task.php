<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['body', 'completed'];

    /**
     * @return mixed
     */
    public function group()
    {
        return $this->belongsTo(Group::class);
    }
}
