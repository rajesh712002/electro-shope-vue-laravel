<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
    use HasFactory;

    public $table= 'subcategories';


    public function category()
    {
        return $this->belongsTo(Category::class,'subcate_id','id');
    }

    public function products()
    {
        return $this->hasMany(Product::class,'sub_category_id','id');
    }
}
