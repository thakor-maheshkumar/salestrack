<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\PaymentRecord;
use Carbon\Carbon;
class SalesInvoice extends Model
{
    use PaymentRecord;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sales_invoice';
    protected $guarded = ['sales_invoice'];
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

    /*public function __construct()
    {
        parent::boot();
    }*/

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
            if(isset($model->sales_order) && !empty($model->sales_order)) {

                $status = (isset($model->sales_order->delivery_note) && $model->sales_order->delivery_note->isNotEmpty()) ? 'completed' : 'billed_not_delivered';

                $model->sales_order->status = $status;
                $model->sales_order->save();
            }
        });
    }

    public function stockItems()
	{
		return $this->hasOne('\App\Models\StockItem', 'id', 'stock_item_id');
    }

    public function customers()
	{
		return $this->hasOne('\App\Models\SalesLedger', 'id', 'sales_ledger_id');
    }

    public function branch()
	{
		return $this->hasOne('\App\Models\ConsigneeAddress', 'id', 'branch_id');
    }

    public function batch()
	{
		return $this->hasOne('\App\Models\Batch', 'id', 'batch_id');
    }

    public function sales_order()
	{
		return $this->belongsTo('\App\Models\SalesOrders', 'sales_order_id');
    }
    /**
     * The purchase order items that belong to the poitems.
     */
    public function items()
    {
        return $this->hasMany('\App\Models\SalesInvoiceItems', 'sales_invoice_id', 'id');
    }

    public function other_charges()
    {
        return $this->hasMany('\App\Models\SalesInvoiceOtherCharges', 'sales_invoice_id', 'id');
    }

    public function editedBy()
    {
        return $this->belongsTo('\App\Models\User', 'edited_by');
    }

    public function sales_person()
    {
        return $this->belongsTo('\App\Models\User', 'sales_person_id');
    }

    public function target_warehouse()
    {
        return $this->belongsTo('\App\Models\Warehouse', 'warehouse_id');
    }

    public function payment()
    {
        return $this->hasOne('\App\Models\Payments', 'voucher_no', 'id')->latest();
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
