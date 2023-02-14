<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Box;

class Inventory extends Model
{
    use HasFactory;

    protected $table = 'inventory';

    protected $fillable = [
        'id_farm',
        'id_section',
        'id_type',
        'id_box',
        'id_inventory_master',
        'id_scaffold',
        'date',
        'master',
        'type',
        'qty',
        'scaffold',
        'status'
    ];

    public function scaffoldItem()
    {
        return $this->hasOne(Scaffold::class, 'id', 'id_scaffold');
    }

    public static function updateStock($id_box) {
        $sum = self::where('id_box', $id_box)
            ->where('type', 1)
            ->where('status', 1)
            ->sum('qty');
        $less = self::where('id_box', $id_box)
            ->where('type', 2)
            ->where('status', 1)
            ->sum('qty');

        $total = $sum - $less;
        Box::where('id', $id_box)->update(['stock' => $total]);
    }
}
