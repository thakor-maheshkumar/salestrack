<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
class PurchaseOrder extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'purchase_orders';
    protected $guarded = ['purchase_orders'];

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
    /*protected $fillable = [
        'id',
        'material_id',
        'supplier_id',
        'approved_vendor_code',
        'branch_id',
        'warehouse_id',
        'order_no',
        'order_date',
        'address',
        'required_date',
        'net_amount',
        'total_net_amount',
        'other_net_amount',
        'total_other_net_amount',
        'discount_in_per',
        'discount_amount',
        'grand_total',
        'igst',
        'sgst',
        'cgst',
        'transporter',
        'reference',
        'credit_days',
        'status',
        'active',
    ];*/

    public static $po_statuses = [
        '0' => 'a-Not Billed or Received',
        '1' => 'b-Received - Not Billed',
        '2' => 'c-Billed - Not Received',
        '3' => 'd-Ordered & Billed'
    ];

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
            // pred($model->material_request);
            if(isset($model->material_request) && !empty($model->material_request)) {
                $model->material_request->status = \App\Models\Materials::$statuses[1];
                $model->material_request->save();
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

    public function branches()
	{
		return $this->hasOne('\App\Models\ConsigneeAddress', 'id', 'branch_id');
    }

    /**
     * The purchase order items that belong to the poitems.
     */
    public function items()
    {
        return $this->hasMany('\App\Models\PoItems', 'po_id', 'id');
    }
    public function purchase_items()
    {
        return $this->hasOne('\App\Models\PoItems', 'po_id', 'id');
    }
    public function other_charges()
    {
        return $this->hasMany('\App\Models\PoOtherCharges', 'po_id', 'id');
    }

    public function material_request()
    {
        return $this->belongsTo('\App\Models\Materials', 'material_id');
    }

    public function purchase_invoice()
    {
        return $this->hasMany('\App\Models\PurchaseInvoice', 'po_id', 'id');
    }

    public function purchase_receipt()
    {
        return $this->hasMany('\App\Models\PurchaseReceipt', 'po_id', 'id');
    }

    public function editedBy()
    {
        return $this->belongsTo('\App\Models\User', 'edited_by');
    }

    public function target_warehouse()
    {
        return $this->belongsTo('\App\Models\Warehouse', 'warehouse_id');
    }
    public function setOrderDateAttribute($value)
    {
        $this->attributes['order_date']= Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
    }
    public function getOrderDateAttribute($value)
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
