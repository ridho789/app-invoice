<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Observers\HistoryStateObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy([HistoryStateObserver::class])]
class State extends Model
{
    use HasFactory;
    protected $table = 'tbl_states';
    protected $primaryKey = 'id_state';

    protected $fillable = [
        'name',
        'id_history'
    ];
}
