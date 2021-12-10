<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductionPlanItems extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
	protected $table = 'production_plan_items';

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
        'quantity',
        'status',
        'active'
    ];
    
    public function stockItems()
	{
		return $this->belongsTo('\App\Models\StockItem', 'stock_item_id');
    }
    
    public function bom()
    {
        return $this->hasMany('\App\Models\Bom');
    }

    public function plans()
    {
        return $this->belongsTo('\App\Models\ProductionPlanItems','plan_id');
    }
    /*public function plans() 
   {
      return $this->hasMany('\App\Models\ProductionPlan');
   }*/
}
