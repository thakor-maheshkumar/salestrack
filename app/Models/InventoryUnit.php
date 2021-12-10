<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventoryUnit extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
	protected $table = 'inventory_units';

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
        'symbol',
        'name',
        'unit_quantity_code',
        'no_of_decimal_places',
        'active'
	];

	/**
     * Define the relation between InventoryUnit and UnitData.
     */
	public function unit_code()
	{
		return $this->belongsTo('\App\Models\UnitData', 'unit_quantity_code', 'id');
    }

    public function StockItem()
	{
		return $this->hasMany('\App\Models\StockItem', 'unit_id', 'id');
	}
}
