<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubTask extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    public function task(){
        return $this->belongsTo(Task::class);
    }

    public function image(){
        return $this->hasOne(SubTaskImage::class, 'subtask_id');
    }
}
