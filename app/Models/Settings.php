<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Settings extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = ['key','value'];

    
    public function getSettings($key = null)
    {
        $this->when($key,function($q) use ($key){
            $q->where('key',$key);
        })->get();
    }
}
