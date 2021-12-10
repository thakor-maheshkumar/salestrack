<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentAmountItems extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'payment_amount_items';

    protected $guarded = ['payment_amount_items'];

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

    public function payment()
    {
        return $this->belongsTo('\App\Models\Payments', 'payment_id');
    }

    public function suppliers()
	{
		return $this->hasOne('\App\Models\PurchaseLedger', 'id', 'party');
    }

    public function customers()
	{
		return $this->hasOne('\App\Models\SalesLedger', 'id', 'party');
    }

    public function general()
	{
		return $this->hasOne('\App\Models\GeneralLedger', 'id', 'party');
    }

    public function sales_invoice()
	{
		return $this->hasOne('\App\Models\SalesInvoice', 'id', 'invoice_no');
    }

    public function purchase_invoice()
	{
		return $this->hasOne('\App\Models\PurchaseInvoice', 'id', 'invoice_no');
    }
}
