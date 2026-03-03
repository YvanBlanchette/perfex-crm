<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class ActivityLog extends Model {
    protected $fillable = ['user_id','subject_type','subject_id','action','description','properties','ip_address'];
    protected $casts    = ['properties'=>'array'];
    public function user() { return $this->belongsTo(User::class); }
    public static function log(string $action, string $desc, mixed $subject=null, array $props=[], ?int $uid=null): self {
        return static::create(['user_id'=>$uid??auth()->id(),'subject_type'=>$subject?get_class($subject):null,'subject_id'=>$subject?->id,'action'=>$action,'description'=>$desc,'properties'=>$props,'ip_address'=>request()?->ip()]);
    }
}