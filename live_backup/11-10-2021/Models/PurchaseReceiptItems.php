<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseReceiptItems extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
	protected $table = 'purchase_receipt_items';

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

    protected $touches = ['purchase_receipt'];

    /**
     * fillable column name goes here
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'receipt_id',
        'stock_item_id',
        'item_code',
        'unit',
        'po_quantity',
        'receipt_quantity',
        'no_of_container',
        'batch_id',
        'active',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function($model){
            if($user_id = \Sentinel::getUser()->id)
            {
                $model->purchase_receipt->edited_by = $user_id;
                $model->purchase_receipt->save();
            }
        });

        static::updating(function($model){
            if($user_id = \Sentinel::getUser()->id)
            {
                $model->purchase_receipt->edited_by = $user_id;
                $model->purchase_receipt->save();
            }
        });
    }

    public function stockItems()
	{
		return $this->hasOne('\App\Models\StockItem', 'id', 'stock_item_id');
    }

    public function purchase_receipt()
    {
        return $this->belongsTo('\App\Models\PurchaseReceipt', 'receipt_id');
    }
}
