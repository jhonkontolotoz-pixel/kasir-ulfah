<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Ability;
use App\Models\User;

class Role extends Model
{
    use HasFactory;

    protected $fillable = ['name','label'];

    public function abilities()
    {
        return $this->belongsToMany(Ability::class)->withTimestamps();
    }

    public function user()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    public function allowTo($ability)
    {
        $this->abilities()->save($ability);
    }

}
