<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseInvoiceItems extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'purchase_invoice_items';
    protected $guarded = ['purchase_invoice_items'];
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

    protected $touches = ['purchase_invoice'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function($model){
            if($user_id = \Sentinel::getUser()->id)
            {
                $model->purchase_invoice->edited_by = $user_id;
                $model->purchase_invoice->save();
            }
        });

        static::updating(function($model){
            if($user_id = \Sentinel::getUser()->id)
            {
                $model->purchase_invoice->edited_by = $user_id;
                $model->purchase_invoice->save();
            }
        });
    }

    public function stock_items()
    {
        return $this->belongsTo('\App\Models\StockItem', 'stock_item_id');
    }

    public function purchase_invoice()
    {
        return $this->belongsTo('\App\Models\PurchaseInvoice', 'purchase_invoice_id');
    }
}
