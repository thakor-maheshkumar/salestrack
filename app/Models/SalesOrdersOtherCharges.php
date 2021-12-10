<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalesOrdersOtherCharges extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sales_orders_other_charges';
    protected $guarded = ['sales_orders_other_charges'];
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

    protected $touches = ['sales_order'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function($model){
            if($user_id = \Sentinel::getUser()->id)
            {
                $model->sales_order->edited_by = $user_id;
                $model->sales_order->save();
            }
        });

        static::updating(function($model){
            if($user_id = \Sentinel::getUser()->id)
            {
                $model->sales_order->edited_by = $user_id;
                $model->sales_order->save();
            }
        });
    }

    public function stock_items()
    {
        return $this->hasOne('\App\Models\StockItem', 'id', 'stock_item_id');
    }

    public function sales_order()
    {
        return $this->belongsTo('\App\Models\SalesOrders', 'sales_order_id');
    }
}
