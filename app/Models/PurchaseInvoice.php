<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\PaymentRecord;
use Carbon\Carbon;
class PurchaseInvoice extends Model
{
    use PaymentRecord;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'purchase_invoices';
    protected $guarded = ['purchase_invoices'];
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

    protected static function boot()
    {
        parent::boot();

        static::creating(function($model){
            if($user_id = \Sentinel::getUser()->id)
            {
                $model->edited_by = $user_id;
            }
        });

        static::updating(function($model){
            if($user_id = \Sentinel::getUser()->id)
            {
                $model->edited_by = $user_id;
            }
        });

        static::saved(function($model) {
            if(isset($model->purchase_order) && !empty($model->purchase_order)) {

                $po_status = (isset($model->purchase_order->purchase_receipt) && $model->purchase_order->purchase_receipt->isNotEmpty()) ? 3 : 2;

                $model->purchase_order->po_status = $po_status;
                $model->purchase_order->save();
            }
        });
    }


    public function stockItems()
	{
		return $this->hasOne('\App\Models\StockItem', 'id', 'stock_item_id');
    }

    public function suppliers()
	{
		return $this->hasOne('\App\Models\PurchaseLedger', 'id', 'supplier_id');
    }

    public function branch()
	{
		return $this->hasOne('\App\Models\ConsigneeAddress', 'id', 'branch_id');
    }

    /**
     * The purchase order items that belong to the poitems.
     */
    public function items()
    {
        return $this->hasMany('\App\Models\PurchaseInvoiceItems', 'purchase_invoice_id', 'id');
    }

    public function other_charges()
    {
        return $this->hasMany('\App\Models\PurchaseInvoiceOtherCharges', 'purchase_invoice_id', 'id');
    }

    public function purchase_order()
    {
        return $this->belongsTo('\App\Models\PurchaseOrder', 'po_id');
    }

    public function editedBy()
    {
        return $this->belongsTo('\App\Models\User', 'edited_by');
    }

    public function target_warehouse()
    {
        return $this->belongsTo('\App\Models\Warehouse', 'warehouse_id');
    }
    public function setInvoiceDateAttribute($value)
    {
        $this->attributes['invoice_date']= Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
    }
    public function getInvoiceDateAttribute($value)
    {
        $date = Carbon::parse($value);
        return $date->format('d/m/Y');
    }
    public function setRequiredDateAttribute($value)
    {
        $this->attributes['required_date']= Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
    }
    public function getRequiredDateAttribute($value)
    {
        $date = Carbon::parse($value);
        return $date->format('d/m/Y');
    }
    public function getUpdatedAtAttribute($value)
    {
        $date = Carbon::parse($value);
        return $date->format('d/m/Y h:i:s');
    }
}
