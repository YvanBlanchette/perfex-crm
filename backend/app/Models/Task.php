<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Task extends Model {
    use HasFactory;
    protected $fillable = ['project_id','name','description','status','priority','start_date','due_date','estimated_hours','assigned_to','created_by'];
    protected $casts    = ['start_date'=>'date','due_date'=>'date'];
    public function project()  { return $this->belongsTo(Project::class); }
    public function assignee() { return $this->belongsTo(User::class, 'assigned_to'); }
    public function timers()   { return $this->hasMany(TaskTimer::class); }
}