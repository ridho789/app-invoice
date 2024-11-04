<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AirBillRecap extends Model
{
    use HasFactory;
    protected $table = 'tbl_air_bill_recaps';
    protected $primaryKey = 'id_air_bill_recap';

    protected $fillable = [
        'id_air_shipment',
        'inv_no',
        'freight_type',
        'size',
        'unit_price',
        'amount',
        'payment_date',
        'payment_amount',
        'remaining_bill',
        'overdue_bill',
    ];
}
