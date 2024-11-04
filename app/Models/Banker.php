<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Observers\HistoryBankerObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy([HistoryBankerObserver::class])]
class Banker extends Model
{
    use HasFactory;
    protected $table = 'tbl_bankers';
    protected $primaryKey = 'id_banker';

    protected $fillable = [
        'name',
        'id_history'
    ];
}
