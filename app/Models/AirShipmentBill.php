<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Observers\HistoryAirShipmentBillObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy([HistoryAirShipmentBillObserver::class])]
class AirShipmentBill extends Model
{
    use HasFactory;
    protected $table = 'tbl_air_shipment_bill';
    protected $primaryKey = 'id_air_shipment_bill';

    protected $fillable = [
        'id_air_shipment',
        'id_history',
        'date',
        'code',
        'transport',
        'bl',
        'permit',
        'insurance'
    ];

}
