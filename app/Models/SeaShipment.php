<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Observers\HistorySeaShipmentObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy([HistorySeaShipmentObserver::class])]
class SeaShipment extends Model
{
    use HasFactory;
    protected $table = 'tbl_sea_shipment';
    protected $primaryKey = 'id_sea_shipment';

    protected $fillable = [
        'no_aju',
        'no_inv',
        'pricelist',
        'bill_diff',
        'date',
        'id_origin',
        'etd',
        'eta',
        'id_shipper',
        'id_customer',
        'id_ship',
        'is_weight',
        'term',
        'file_shipment_status',
        'value_key',
        'is_printed',
        'printcount',
        'printdate',
        'id_history'
    ];

    public function customer() {
        return $this->belongsTo(Customer::class, 'id_customer', 'id_customer');
    }

    public function company() {
        return $this->belongsTo(Company::class, 'id_company', 'id_company');
    }
}
