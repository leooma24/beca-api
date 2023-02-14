<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryMaster extends Model
{
    use HasFactory;

    protected $table = 'inventory_master';

    protected $fillable = [
        'id_farm',
        'id_type',
        'date',
        'customer',
        'driver',
        'batch',
        'description',
        'status'
    ];

    public function items()
    {
        return $this->hasMany(Inventory::class, 'id_inventory_master');
    }

    public function type()
    {
        return $this->hasOne(Type::class, 'id', 'id_type');
    }

    public function farm()
    {
        return $this->hasOne(Farm::class, 'id', 'id_farm');
    }
}
