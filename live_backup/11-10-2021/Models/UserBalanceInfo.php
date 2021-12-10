<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
//use App\Traits\PaymentRecord;
use Carbon\Carbon;

class UserBalanceInfo extends Model
{
	//use PaymentRecord;

    /**
     * The table associated with the model.
     *
     * @var string
     */
	protected $table = 'users_balance_info';

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
        'user_id',
        'total_balance',
        'ledger_type'
    ];
}
?>