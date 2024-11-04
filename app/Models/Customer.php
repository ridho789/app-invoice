<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Observers\HistoryCustomerObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy([HistoryCustomerObserver::class])]
class Customer extends Model
{
    use HasFactory;
    protected $table = 'tbl_customers';
    protected $primaryKey = 'id_customer';

    protected $fillable = [
        'name',
        'discount',
        'shipper_ids',
        'bill_diff',
        'inv_type',
        'is_bill_weight',
        'id_company',
        'id_account',
        'id_banker',
        'id_history',
    ];

    public function company() {
        return $this->belongsTo(Company::class, 'id_company', 'id_company');
    }
}
