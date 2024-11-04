<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Observers\HistoryPricelistObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy([HistoryPricelistObserver::class])]
class Pricelist extends Model
{
    use HasFactory;
    protected $table = 'tbl_pricelists';
    protected $primaryKey = 'id_pricelist';

    protected $fillable = [
        'id_pricelist',
        'id_shipper',
        'id_customer',
        'id_origin',
        'price',
        'type',
        'start_period',
        'end_period',
        'id_history'
    ];
}
