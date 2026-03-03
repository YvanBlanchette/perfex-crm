<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class InvoiceItem extends Model {
    protected $fillable = ['invoice_id','description','long_description','qty','rate','unit'];
    public function invoice() { return $this->belongsTo(Invoice::class); }
}