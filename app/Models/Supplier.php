<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'identification_number',
        'razon_social_bol',
        'company_name',
        'supplier_contact_name',
        'supplier_contact_phone',
        'supplier_contact_email',
        'created_by'
    ];
}
