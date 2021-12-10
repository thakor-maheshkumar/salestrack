<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
class Stock extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
	protected $table = 'stocks';

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
        'voucher_no',
        'stock_transfer_no',
        'transaction_type',
        'stock_transfer_type',
        'date',
        'active',
        'suffix',
        'prefix',
        'series_type',
        'number',
        'document_no',
        'stock_status'
	];

	public function stock_source_items()
	{
		return $this->hasMany('\App\Models\StockSourceItem', 'stock_id');
	}
    public function batch()
    {
        return $this->hasMany('\App\Models\Batch', 'batch_id');
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
    public function stock_managements()
    {
        return $this->hasMany('\App\Models\StockManagement','document_no','document_no');
    }
}
