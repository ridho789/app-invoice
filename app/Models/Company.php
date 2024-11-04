<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    protected $table = 'tbl_companies';
    protected $primaryKey = 'id_company';

    protected $fillable = [
        'name',
        'shorter',
        'id_history'
    ];
}
