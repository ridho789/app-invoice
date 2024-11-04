<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Observers\HistoryAccountObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy([HistoryAccountObserver::class])]
class Account extends Model
{
    use HasFactory;
    protected $table = 'tbl_accounts';
    protected $primaryKey = 'id_account';

    protected $fillable = [
        'account_no',
        'id_history'
    ];
}
