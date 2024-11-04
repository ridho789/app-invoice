<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Insurance extends Model
{
    use HasFactory;
    protected $table = 'tbl_insurances';

    protected $fillable = [
        'id_sea_shipment_line',
        'id_item',
        'quantity',
        'unit',
        'description',
        'currency',
        'original_price',
        'exchange_rate',
        'idr',
        'premi',
        'id_history'
    ];
}
