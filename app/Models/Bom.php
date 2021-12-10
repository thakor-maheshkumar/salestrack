<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bom extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
	protected $table = 'bom';

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
        'id',
        'stock_item_id',
        'bom_name',
        'no_of_unit',
        'rate_of_material',
        'additional_cost',
        'active'
    ];
    
    public function stockItems()
	{
		return $this->belongsTo('\App\Models\StockItem', 'stock_item_id');
    }
    
    /**
     * The stock items that belong to the bom.
     */
    public function bom_items()
    {
        return $this->hasMany('\App\Models\BomStockItems');
    }
}
