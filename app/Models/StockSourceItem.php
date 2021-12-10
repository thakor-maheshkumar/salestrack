<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockSourceItem extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
	protected $table = 'stock_source_items';

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
        'stock_id',
        'source_warehouse',
        'target_warehouse',
        'item_id',
        'item_name',
        'item_code',
        'uom',
        'quantity',
        'rate',
        'batch_id',
        'target_batch_id',
        'document_no',
        'voucher_type',
	];

    public function batch()
    {
        return $this->hasOne('\App\Models\Batch', 'id', 'batch_id');
    }
    public function unit()
    {
        return $this->hasOne('\App\Models\InventoryUnit', 'id', 'uom');
    }
    public function warehouse()
    {
        return $this->hasOne('\App\Models\Warehouse', 'id', 'source_warehouse');
    }
    public function targetbatchid()
    {
        return $this->hasOne('\App\Models\Batch', 'id', 'target_batch_id');
    }
    
    
}
