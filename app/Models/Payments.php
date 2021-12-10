<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
//use App\Traits\PaymentRecord;

class Payments extends Model
{
	use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'payments';

    protected $guarded = ['payments'];
    
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
     * The amount items that belong to the Payments.
     */
    public function amount_items()
    {
        return $this->hasOne('\App\Models\PaymentAmountItems', 'payment_id', 'id');
    }

    
}
