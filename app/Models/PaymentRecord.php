<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
class PaymentRecord extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'payment_records';

    protected $guarded = ['payment_records'];
    
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
     * Set the record to morph.
     *
     */
    public function recordable()
    {
    	return $this->morphTo();
    }
    public function getPostingDateAttribute($value)
    {
        $date = Carbon::parse($value);
        return $date->format('d/m/Y h:i:s');
    }

    public function suppliers()
	{
		return $this->hasOne('\App\Models\PurchaseLedger', 'id', 'party');
    }

    public function customers()
	{
		return $this->hasOne('\App\Models\SalesLedger', 'id', 'party');
    }
}
