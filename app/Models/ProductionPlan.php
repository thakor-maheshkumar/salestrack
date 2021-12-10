<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
class ProductionPlan extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
	protected $table = 'production_plan';

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
        'plan_id',
        'stock_item_id',
        'batch_id',
        'warehouse_id',
        'so_id',
        'quantity',
        'bom_id',
        'status',
        'active',
        'suffix',
        'prefix',
        'number',
        'series_type',
        'production_date',
    ];
    
    public function stockItems()
	{
		return $this->hasOne('\App\Models\StockItem','id','stock_item_id');
    }
    
    public function bom()
    {
        return $this->hasOne('\App\Models\Bom','id','bom_id');
    }

    public function warehouse()
    {
        return $this->hasOne('\App\Models\Warehouse','id','warehouse_id');
    }

    public function batch()
    {
        return $this->hasOne('\App\Models\Batch','id','batch_id');
    }

    public function salesorder()
    {
        return $this->hasOne('\App\Models\SalesOrders','id','so_id');
    }

    /**
     * The stock items that belong to the bom.
     */
    public function bom_items()
    {
        return $this->hasMany('\App\Models\BomStockItems');
    }

    public function plan_items()
    {
        return $this->hasMany('\App\Models\ProductionPlanItems');
    }
    /*public function planItems()
    {
        return $this->belongsTo('\App\Models\ProductionPlanItems','id');
    }*/
    public function setProductionDateAttribute($value)
    {
        $this->attributes['production_date']= Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
    }
    public function getProductionDateAttribute($value)
    {
        $date = Carbon::parse($value);
        return $date->format('d/m/Y');
    }
}
