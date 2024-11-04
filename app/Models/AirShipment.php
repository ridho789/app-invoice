<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Observers\HistoryAirShipmentObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;


#[ObservedBy([HistoryAirShipmentObserver::class])]
class AirShipment extends Model
{
    use HasFactory;

    protected $table = 'tbl_air_shipment';
    protected $primaryKey = 'id_air_shipment';

    protected $fillable = [
        'id_shipper',
        'id_customer',
        'id_history',
        'no_inv',
        'id_origin',
        'vessel_sin',
        'date',
        'bl',
        'pricelist',
        'term',
        'file_shipment_status',
        'is_printed',
        'printcount',
        'printdate',
        'value_key',
    ];

    public function customer() {
        return $this->belongsTo(Customer::class, 'id_customer', 'id_customer');
    }

    public function company() {
        return $this->belongsTo(Company::class, 'id_company', 'id_company');
    }
}
