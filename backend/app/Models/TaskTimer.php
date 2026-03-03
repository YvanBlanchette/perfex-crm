<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class TaskTimer extends Model {
    protected $fillable = ['task_id','user_id','started_at','ended_at','note'];
    protected $casts    = ['started_at'=>'datetime','ended_at'=>'datetime'];
    public function task() { return $this->belongsTo(Task::class); }
}