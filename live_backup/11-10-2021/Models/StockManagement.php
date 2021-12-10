<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockManagement extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'stock_management';
    protected $guarded = ['stock_management'];
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

  public function scopeFilter($query, $filters)
  {
    if( isset($filters['warehouse_id']) ){
      $query->where('warehouse_id', '=', $filters['warehouse_id']);
    }
    /*if( isset($filters['stock_item_id']) ){
      $query->where('stock_item_id', '=', $filters['stock_item_id']);
    }

    if( isset($filters['stock_item_id']) ){
      $query->where('stock_item_id', '=', $filters['stock_item_id']);
    }*/

  }
}
