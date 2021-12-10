<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
class Batch extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
	protected $table = 'batches';

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
        'stock_item_id',
        'warehouse_id',
        'batch_id',
        'batch_size',
        'manufacturing_date',
        'expiry_date',
        'description',
        'is_enabled',
        'active'
    ];
   
    public function stockItems()
	{
		return $this->belongsTo('\App\Models\StockItem', 'stock_item_id');
    }

    public function warehouse()
	{
		return $this->belongsTo('\App\Models\Warehouse', 'warehouse_id');
    }
    public function setManufacturingDateAttribute($value)
    {
        $this->attributes['manufacturing_date']= Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
    }
    public function getManufacturingDateAttribute($value)
    {
        $date = Carbon::parse($value);
        return $date->format('d/m/Y');
    }
    public function setExpiryDateAttribute($value)
    {
        $this->attributes['expiry_date']= Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
    }
    public function getExpiryDateAttribute($value)
    {
        $date = Carbon::parse($value);
        return $date->format('d/m/Y');
    }
}
