<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
class Materials extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
	protected $table = 'materials';

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
        'series_id',
        'type',
        'required_date',
        'active',
        'edited_by',
        'status',
        'series_type',
        'prefix',
        'suffix',
        'number'
    ];

    public static $statuses = [
        '0' => 'Pending',
        '1' => 'Ordered'
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
    }

    public function stockItems()
	{
		return $this->hasOne('\App\Models\StockItem', 'id', 'stock_item_id');
    }

    /**
     * The stock items that belong to the bom.
     */
    public function material_items()
    {
        return $this->hasMany('\App\Models\MaterialStockItems', 'material_id', 'id');
    }

    public function purchase_order()
    {
        return $this->hasOne('\App\Models\PurchaseOrder', 'material_id', 'id');
    }

    public function editedBy()
    {
        return $this->belongsTo('\App\Models\User', 'edited_by');
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
