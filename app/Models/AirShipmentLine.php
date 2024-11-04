<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Observers\HistoryAirShipmentLineObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy([HistoryAirShipmentLineObserver::class])]
class AirShipmentLine extends Model
{
    use HasFactory;
    protected $table = 'tbl_air_shipment_line';
    protected $primaryKey = 'id_air_shipment_line';

    protected $fillable = [
        'id_history',
        'id_air_shipment',
        'id_unit',
        'date',
        'marking',
        'koli',
        'qty_pkgs',
        'qty_loose',
        'qty',
        'note',
    ];

}
