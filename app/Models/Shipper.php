<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Observers\HistoryShipperObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy([HistoryShipperObserver::class])]
class Shipper extends Model
{
    use HasFactory;
    protected $table = 'tbl_shippers';
    protected $primaryKey = 'id_shipper';

    protected $fillable = [
        'name',
        'id_history'
    ];
}
