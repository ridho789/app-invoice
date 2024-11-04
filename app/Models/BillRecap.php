<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillRecap extends Model
{
    use HasFactory;
    protected $table = 'tbl_bill_recaps';
    protected $primaryKey = 'id_bill_recap';

    protected $fillable = [
        'id_sea_shipment',
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
