<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Observers\HistorySeaShipmentBillObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy([HistorySeaShipmentBillObserver::class])]
class SeaShipmentBill extends Model
{
    use HasFactory;
    protected $table = 'tbl_sea_shipment_bill';
    protected $primaryKey = 'id_sea_shipment_bill';

    protected $fillable = [
        'id_sea_shipment',
        'id_history',
        'date',
        'code',
        'transport',
        'bl',
        'permit',
        'insurance'
    ];
}
