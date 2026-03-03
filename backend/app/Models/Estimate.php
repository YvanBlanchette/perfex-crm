<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Estimate extends Model {
    use HasFactory;
    protected $fillable = ['client_id','number','portal_token','status','date','expiry_date','subtotal','discount','discount_type','tax','total','currency','terms'];
    protected $casts    = ['date'=>'date','expiry_date'=>'date'];
    public function client() { return $this->belongsTo(Client::class); }
    public function items()  { return $this->hasMany(EstimateItem::class); }
}