<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Observers\HistorySeaShipmentLineObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy([HistorySeaShipmentLineObserver::class])]
class SeaShipmentLine extends Model
{
    use HasFactory;
    protected $table = 'tbl_sea_shipment_line';
    protected $primaryKey = 'id_sea_shipment_line';

    protected $fillable = [
        'id_sea_shipment',
        'id_unit',
        'date',
        'code',
        'marking',
        'qty_pkgs',
        'id_uom_pkgs',
        'qty_loose',
        'id_uom_loose',
        'weight',
        'dimension_p',
        'dimension_l',
        'dimension_t',
        'tot_cbm_1',
        'tot_cbm_2',
        'lts',
        'qty',
        'desc',
        'id_state',
        'id_history'
    ];
}
