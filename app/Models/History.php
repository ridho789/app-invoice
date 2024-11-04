<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    use HasFactory;
    protected $table = 'tbl_histories';
    protected $primaryKey = 'id_history';

    protected $fillable = [
        'id_changed_data',
        'scope',
        'older_data',
        'changed_data',
        'action',
        'user_id',
        'revcount'
    ];
}
