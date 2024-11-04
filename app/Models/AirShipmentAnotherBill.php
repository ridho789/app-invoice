<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Observers\HistoryAirShipmentAnotherBillObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy([HistoryAirShipmentAnotherBillObserver::class])]
class AirShipmentAnotherBill extends Model
{
    use HasFactory;
    protected $table = 'tbl_air_shipment_other_bill';
    protected $primaryKey = 'id_air_shipment_other_bill';

    protected $fillable = [
        'id_air_shipment',
        'id_history',
        'id_desc',
        'date',
        'charge',
        'note'
    ];
}
