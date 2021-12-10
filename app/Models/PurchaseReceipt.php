<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\PaymentRecord;
use Carbon\Carbon;
class PurchaseReceipt extends Model
{
    use PaymentRecord;

    /**
     * The table associated with the model.
     *
     * @var string
     */
	protected $table = 'purchase_receipt';

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
        'id',
        'po_id',
        'supplier_id',
        'branch_id',
        'main_branch',
        'warehouse_id',
        'receipt_no',
        'date',
        'address',
        'qc_status',
        'approved_vendor_code',
        'shortage_qty',
        'good_condition_container',
        'container_have_product',
        'container_have_tare_weight',
        'good_condition_container_remark',
        'container_have_product_remark',
        'container_have_tare_weight_remark',
        'container_dedust_with',
        'dedust_done_by',
        'dedust_check_by',
        'active',
        'edited_by',
        'batch_id',
        'voucher_no',
        'suffix',
        'prefix',
        'number',
        'series_type'
    ];

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
            if(isset($model->purchase_order) && !empty($model->purchase_order)) {

                $po_status = (isset($model->purchase_order->purchase_invoice) && $model->purchase_order->purchase_invoice->isNOtEmpty()) ? 3 : 1;

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

    public function warehouse()
	{
		return $this->hasOne('\App\Models\Warehouse', 'id', 'warehouse_id');
    }

     public function batch()
	{
		return $this->hasOne('\App\Models\Batch', 'id', 'batch_id');
    }

    public function purchase_items()
    {
        return $this->hasOne('\App\Models\PurchaseReceiptItems', 'receipt_id', 'id');
    }

    /**
     * The purchase order items that belong to the poitems.
     */
    public function items()
    {
        return $this->hasMany('\App\Models\PoItems', 'po_id', 'id');
    }

    public function purchase_order()
    {
        return $this->belongsTo('\App\Models\PurchaseOrder', 'po_id');
    }

    public function qc_reports()
    {
        return $this->hasOne('\App\Models\QcReports', 'purchase_receipt_id');
    }

    public function editedBy()
    {
        return $this->belongsTo('\App\Models\User', 'edited_by');
    }

    public function payment()
    {
        // new changes in 20-10-2021 ///
        return $this->hasOne('\App\Models\Payments', 'id')->latest();
        //return $this->hasOne('\App\Models\Payments', 'voucher_no', 'id')->latest();
    }
    public function setDateAttribute($value)
    {
        $this->attributes['date']= Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
    }
    public function getDateAttribute($value)
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
