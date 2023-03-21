<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $table = 'products';


    protected $guarded = ['id'];

    public function detail_products()
    {
        return $this->hasMany(DetailProduct::class, 'product_id');
    }
}
