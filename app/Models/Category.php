<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory,SoftDeletes;

    protected $casts = [
        
        'created_at' => 'datetime:Y-m-d h:i a',
        'updated_at' => 'datetime:Y-m-d h:i a',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name','description'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

}
