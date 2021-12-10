<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeliveryNoteItems extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sales_delivery_note_items';
    protected $guarded = ['sales_delivery_note_items'];
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

    //protected $touches = ['sales_delivery_note'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function($model){
            if($user_id = \Sentinel::getUser()->id)
            {
                // $model->sales_order->edited_by = $user_id;
                // $model->sales_order->save();
            }
        });

        static::updating(function($model){
            if($user_id = \Sentinel::getUser()->id)
            {
                // $model->sales_order->edited_by = $user_id;
                // $model->sales_order->save();
            }
        });
    }

    public function stockItems()
	{
		return $this->belongsTo('\App\Models\StockItem', 'stock_item_id');
    }
    
    public function delivery_notes()
    {
        return $this->belongsTo('\App\Models\DeliveryNote', 'delivery_note_id');
    }
}
