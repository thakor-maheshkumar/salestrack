<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockQtyManagement extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'stock_qty_management';
    protected $guarded = ['stock_qty_management'];
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

    public function stockItems()
	{
		  return $this->hasOne('\App\Models\StockItem', 'id', 'stock_item_id');
    }

    public function batch()
	{
		return $this->hasOne('\App\Models\Batch', 'id', 'batch_id');
    }

    public function warehouse()
	{
		return $this->hasOne('\App\Models\Warehouse', 'id', 'warehouse_id');
    }
}
