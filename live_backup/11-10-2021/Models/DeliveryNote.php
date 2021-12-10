<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
class DeliveryNote extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sales_delivery_note';
    protected $guarded = ['sales_delivery_note'];
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

    public static $statuses = [
        'pending' => 'Pending',
        'delivered_not_billed' => 'Delivered not Billed',
        'billed_not_delivered' => 'Billed not Delivered',
        'completed' => 'Completed'
    ];

    protected static function boot()
    {
        parent::boot();

        // static::creating(function($model){
        //     if($user_id = \Sentinel::getUser()->id)
        //     {
        //         $model->edited_by = $user_id;
        //     }
        // });

        // static::updating(function($model){
        //     if($user_id = \Sentinel::getUser()->id)
        //     {
        //         $model->edited_by = $user_id;
        //     }
        // });
    }

    public function stockItems()
	{
		return $this->hasOne('\App\Models\StockItem', 'id', 'stock_item_id');
    }

    public function customers()
	{
		return $this->hasOne('\App\Models\SalesLedger', 'id', 'customer_id');
    }

    public function branch()
	{
		return $this->hasOne('\App\Models\ConsigneeAddress', 'id', 'branch_id');
    }

    public function items()
    {
        return $this->hasMany('\App\Models\DeliveryNoteItems', 'delivery_note_id');
    }

    public function other_charges()
    {
        return $this->hasMany('\App\Models\DeliveryNoteOtherCharges', 'delivery_note_id');
    }
    public function sales_order()
    {
        return $this->belongsTo('\App\Models\SalesOrders', 'sales_order_id');
    }
    public function target_warehouse()
    {
        return $this->belongsTo('\App\Models\Warehouse', 'warehouse_id');
    }
    
}
?>