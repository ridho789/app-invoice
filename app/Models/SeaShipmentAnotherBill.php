<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Observers\HistorySeaShipmentAnotherBillObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy([HistorySeaShipmentAnotherBillObserver::class])]
class SeaShipmentAnotherBill extends Model
{
    use HasFactory;
    protected $table = 'tbl_sea_shipment_other_bill';
    protected $primaryKey = 'id_sea_shipment_other_bill';

    protected $fillable = [
        'id_sea_shipment',
        'id_history',
        'id_desc',
        'date',
        'charge',
        'note'
    ];
}
