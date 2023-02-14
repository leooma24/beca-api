<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreHouse extends Model
{
    use HasFactory;

    protected $table = 'store_houses';

    protected $fillable = [
        'code',
        'name',
        'status',
    ];
}
