<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Expense extends Model {
    protected $fillable = ['client_id','project_id','category','name','amount','date','currency','billable','note'];
    protected $casts    = ['date'=>'date','billable'=>'boolean'];
    public function client()  { return $this->belongsTo(Client::class); }
    public function project() { return $this->belongsTo(Project::class); }
}