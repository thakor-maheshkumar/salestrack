<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
//use App\Traits\PaymentRecord;
use Carbon\Carbon;

class UserOnAccountBalanceInfo extends Model
{
	//use PaymentRecord;

    /**
     * The table associated with the model.
     *
     * @var string
     */
	protected $table = 'user_on_account_balance_info';

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
        'total_on_account_balance',
        'ledger_type'
    ];
}
?>