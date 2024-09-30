<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use softDeletes;

    protected $fillable = [
        'name',
        'sku',
        'unit_id',
        'brand_id',
        'category_id',
        'enable_stock',
        'alert_quantity',
        'pathImage',
        'purchase_price',
        'margin_of_gain',
        'sale_price',
        'created_by'
    ];
}
