<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    //hasMany設定
    public function images()
    {
        return $this->hasMany('Image','product_id','id');
    }
}
