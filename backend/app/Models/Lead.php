<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Lead extends Model {
    use HasFactory;
    protected $fillable = ['name','title','company','email','phone','website','address','city','country','status','source','assigned_to','value','description','converted_to_client_id'];
    public function assignee() { return $this->belongsTo(User::class, 'assigned_to'); }
}