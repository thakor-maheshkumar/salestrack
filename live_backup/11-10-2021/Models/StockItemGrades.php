<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockItemGrades extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
	protected $table = 'stock_item_grades';

    /**
     * set primary key of table
     *
     * @var integer
     */
    protected $primaryKey = 'id';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * fillable column name goes here
     *
     * @var array
     */
    protected $fillable = [
        'grade_id',
        'stock_item_id',
        'quantity',
        'unit_id',
        'pack_code',
        'active'
	];

    public function stock_items()
    {
        return $this->belongsTo('\App\Models\StockItem', 'stock_item_id', 'id');
    }

    public function InventoryUnit()
    {
        return $this->belongsTo('\App\Models\InventoryUnit', 'unit_id', 'id');
    }

    public function stockGrades()
    {
        return $this->hasMany('\App\Models\Grades', 'id' , 'grade_id');
    }

}
