<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class EstimateItem extends Model {
    protected $fillable = ['estimate_id','description','qty','rate','unit'];
}