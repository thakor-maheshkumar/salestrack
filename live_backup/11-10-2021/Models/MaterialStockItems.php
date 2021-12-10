<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaterialStockItems extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
	protected $table = 'material_stock_items';

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
	 * Indicates if the IDs are auto-incrementing.
	 *
	 * @var bool
	 */
	public $incrementing = true;

    protected $touches = ['materials'];

    /**
     * fillable column name goes here
     *
     * @var array
     */
    protected $fillable = [
    	'id',
        'material_id',
        'stock_item_id',
        'warehouse_id',
        'item_code',
        'uom',
        'quantity'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function($model){
            if($user_id = \Sentinel::getUser()->id)
            {
                $model->materials->edited_by = $user_id;
                $model->materials->save();
            }
        });

        static::updating(function($model){
            if($user_id = \Sentinel::getUser()->id)
            {
                $model->materials->edited_by = $user_id;
                $model->materials->save();
            }
        });
    }

    public function materials()
    {
        return $this->belongsTo('\App\Models\Materials', 'material_id');
    }

    public function item()
    {
        return $this->belongsTo('\App\Models\StockItem', 'stock_item_id');
    }
}
