<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Observers\HistoryUomObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy([HistoryUomObserver::class])]
class Uom extends Model
{
    use HasFactory;
    protected $table = 'tbl_uom';
    protected $primaryKey = 'id_uom';

    protected $fillable = [
        'name',
        'id_history'
    ];
}
