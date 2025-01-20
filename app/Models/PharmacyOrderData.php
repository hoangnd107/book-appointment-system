<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PharmacyOrderData extends Model
{
    use HasFactory;
    protected $table = 'pharmacy_orderdata';
    protected $primaryKey = 'id';
}
