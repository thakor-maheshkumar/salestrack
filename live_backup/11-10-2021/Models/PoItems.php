<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PoItems extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
	protected $table = 'po_items';

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

    protected $touches = ['purchase_order'];

    /**
     * fillable column name goes here
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'po_id',
        'stock_item_id',
        'item_code',
        'unit',
        'quantity',
        'rate',
        'net_amount',
        'tax',
        'tax_amount',
        'discount',
        'discount_in_per',
        'cess',
        'cess_amount',
        'total_amount',
        'item_pending',
        'item_received',
        'status',
        'active'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function($model){
            if($user_id = \Sentinel::getUser()->id)
            {
                $model->purchase_order->edited_by = $user_id;
                $model->purchase_order->save();
            }
        });

        static::updating(function($model){
            if($user_id = \Sentinel::getUser()->id)
            {
                $model->purchase_order->edited_by = $user_id;
                $model->purchase_order->save();
            }
        });
    }

    public function stock_items()
	{
		return $this->belongsTo('\App\Models\StockItem', 'stock_item_id');
    }

    public function purchase_order()
    {
        return $this->belongsTo('\App\Models\PurchaseOrder', 'po_id');
    }

    /*public function purchase_orders()
    {
        return $this->hasMany('\App\Models\PurchaseOrder');
    }*/
}
