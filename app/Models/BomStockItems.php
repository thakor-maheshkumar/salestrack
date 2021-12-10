<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BomStockItems extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
	protected $table = 'bom_stock_items';

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
	 * Indicates if the IDs are auto-incrementing.
	 *
	 * @var bool
	 */
	public $incrementing = true;

    /**
     * fillable column name goes here
     *
     * @var array
     */
    protected $fillable = [
    	'id',
        'bom_id',
        'stock_item_id',
        'quantity'
    ];
    
    public function stockItems()
	{
		return $this->hasMany('\App\Models\StockItem', 'id','stock_item_id');
    }

    public function bom()
    {
        return $this->hasOne('\App\Models\Bom');
    }

}
