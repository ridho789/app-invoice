<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Desc extends Model
{
    use HasFactory;
    protected $table = 'tbl_descs';
    protected $primaryKey = 'id_desc';

    protected $fillable = [
        'name',
    ];
}
