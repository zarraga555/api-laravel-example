<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Person extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'customer_id',
        'suppliers_id',
        'email',
        'phone',
        'mobile',
        'address_one',
        'address_two',
        'country',
        'state',
        'city',
        'postal_code',
        'credit_limit',
        'created_by'
    ];
}
