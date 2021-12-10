<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
class Quotation extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'quotation';

    protected $guarded = ['quotation'];
    
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

    public function customers()
	{
		return $this->hasOne('\App\Models\SalesLedger', 'id', 'sales_ledger_id');
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
        return $this->hasMany('\App\Models\QuotationItems', 'quotation_id', 'id');
    }

    public function other_charges()
    {
        return $this->hasMany('\App\Models\QuotationeOtherCharges', 'quotation_id', 'id');
    }
    
    public function sales_orders()
    {
        return $this->hasMany('\App\Models\SalesOrders', 'quotation_id');
    }

    public function editedBy()
    {
        return $this->belongsTo('\App\Models\User', 'edited_by');
    }
    public function salesPerson()
    {
        return $this->belongsTo('\App\Models\User', 'sales_person_id');
    }

    public function target_warehouse()
    {
        return $this->belongsTo('\App\Models\Warehouse', 'warehouse_id');
    }
    public function setValidTillAttribute($value)
    {
        $this->attributes['valid_till']= Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
    }
    public function getValidTillAttribute($value)
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
