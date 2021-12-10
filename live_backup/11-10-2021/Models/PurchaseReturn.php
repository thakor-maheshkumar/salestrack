<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
class PurchaseReturn extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'purchase_returns';
    protected $guarded = ['purchase_returns'];
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
        return $this->hasMany('\App\Models\PurchaseReturnItems', 'purchase_return_id', 'id');
    }

    public function other_charges()
    {
        return $this->hasMany('\App\Models\PurchaseReturnOtherCharges', 'purchase_return_id', 'id');
    }

    public function editedBy()
    {
        return $this->belongsTo('\App\Models\User', 'edited_by');
    }
    public function target_warehouse()
    {
        return $this->belongsTo('\App\Models\Warehouse', 'warehouse_id');
    }
    public function invoice()
    {
        return $this->belongsTo('\App\Models\PurchaseInvoice', 'invoice_id');
    }
    public function setReturnDateAttribute($value)
    {
        $this->attributes['return_date']= Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
    }
    public function getReturnDateAttribute($value)
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
    