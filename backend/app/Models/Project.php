<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Project extends Model {
    use HasFactory;
    protected $fillable = ['client_id','name','description','status','priority','start_date','deadline','budget','billing_type','rate_per_hour','estimated_hours','progress'];
    protected $casts    = ['start_date'=>'date','deadline'=>'date'];
    public function client()   { return $this->belongsTo(Client::class); }
    public function tasks()    { return $this->hasMany(Task::class); }
    public function members()  { return $this->belongsToMany(User::class, 'project_members'); }
    public function invoices() { return $this->hasMany(Invoice::class); }
}