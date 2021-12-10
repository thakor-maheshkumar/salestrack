<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PoOtherCharges extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
	protected $table = 'po_other_charges';

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
        'general_ledger_id',
        'type',
        'rate',
        'amount',
        'tax',
        'tax_amount',
        'total_amount',
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

    /*public function purchase_orders()
    {
        return $this->hasOne('\App\Models\PurchaseOrder');
    }*/

    public function purchase_order()
    {
        return $this->belongsTo('\App\Models\PurchaseOrder', 'po_id');
    }
}
