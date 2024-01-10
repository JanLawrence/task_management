<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    public function subTask(){
        return $this->hasMany(SubTask::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function image(){
        return $this->hasOne(TaskImage::class);
    }
}
