<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Observers\HistoryShipObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy([HistoryShipObserver::class])]
class Ship extends Model
{
    use HasFactory;
    protected $table = 'tbl_ships';
    protected $primaryKey = 'id_ship';

    protected $fillable = [
        'name',
        'purpose',
        'id_history'
    ];
}
