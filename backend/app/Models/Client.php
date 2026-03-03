<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Client extends Model {
    use HasFactory;
    protected $fillable = ['company_name','email','vat_number','phone','website','address','city','state','zip','country','currency','status','notes'];
    public function contacts()  { return $this->hasMany(Contact::class); }
    public function projects()  { return $this->hasMany(Project::class); }
    public function invoices()  { return $this->hasMany(Invoice::class); }
    public function estimates() { return $this->hasMany(Estimate::class); }
    public function leads()     { return $this->hasMany(Lead::class); }
}