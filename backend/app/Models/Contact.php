<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Contact extends Model {
    protected $fillable = ['client_id','first_name','last_name','email','phone','title','is_primary','password'];
    protected $hidden   = ['password'];
    public function client() { return $this->belongsTo(Client::class); }
}