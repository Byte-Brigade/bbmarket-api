<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetailProduct extends Model
{
    use SoftDeletes;

    protected $table = 'detail_products';

    protected $guarded = ['id'];

    protected $attributes = [
        'variant' => 'default',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
