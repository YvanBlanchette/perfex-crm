<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Invoice extends Model {
    use HasFactory;
    protected $fillable = ['client_id','project_id','number','portal_token','status','date','due_date','subtotal','discount','discount_type','tax','total','currency','terms','client_note'];
    protected $casts    = ['date'=>'date','due_date'=>'date'];
    public function client()   { return $this->belongsTo(Client::class); }
    public function project()  { return $this->belongsTo(Project::class); }
    public function items()    { return $this->hasMany(InvoiceItem::class); }
    public function payments() { return $this->hasMany(Payment::class); }
}