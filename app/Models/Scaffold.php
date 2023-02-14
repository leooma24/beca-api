<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Scaffold extends Model
{
    use HasFactory;

    protected $table = 'scaffolds';

    protected $fillable = [
        'id_box',
        'name',
        'master',
        'qty',
        'kilograms'
    ];

    public function items()
    {
        return $this->hasMany(Inventory::class, 'id_scaffold');
    }

    public function updateStock($items) {
        $sum = $less = 0;
        foreach($items as $item) {
            if($item->type == 1) {
                $sum += $item->master;
            } else {
                $less += $item->master;
            }
        }

        $this->master = $sum - $less;
        $this->qty = $this->master * 10;
        $this->kilograms = $this->qty * 2;
        $this->save();
    }
}
