<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;
    protected $table = 'tbl_units';
    protected $primaryKey = 'id_unit';

    protected $fillable = [
        'name',
    ];
}
