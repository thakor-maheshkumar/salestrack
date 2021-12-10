<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\PaymentRecord;
//use App\Traits\UserBalanceInfo;
use Carbon\Carbon;
class SalesLedger extends Model
{
	use PaymentRecord;
    //use UserBalanceInfo;
    /**
     * The table associated with the model.
     *
     * @var string
     */
	protected $table = 'sales_ledgers';

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
        'ledger_name',
        'customer_group',
		'under',
		'gst_reg_type',
		'gstin_uin',
		'gstin_applicable_date',
		'party_type',
		'pan_it_no',
		'uid_no',
		'is_tds_deductable',
		'include_assessable_value',
		'applicable',
		'address',
		'branchname',
		'city',
		'state',
		'pincode',
		'location',
		'mobile_no',
		'landline_no',
		'fax_no',
		'website',
		'email',
		'cc_email',
		'consignee_address',
		'maintain_balance_bill_by_bill',
		'default_credit_period',
		'default_credit_amount',
		'credit_days_during_voucher_entry',
		'credit_amount_during_voucher_entry',
		'active_interest_calculation',
		'opening_balance',
		'opening_balance_amount',
		'customer_number',
	];

	/*public function __construct()
    {
        parent::boot();
    }*/

    protected static function boot()
    {
        parent::boot();
    }

	public function group()
	{
		return $this->hasOne('\App\Models\Groups', 'id', 'under');
	}
	public function customergroups()
	{
		return $this->belongsTo('\App\Models\CustomerGroup','customer_group','id');
	}
	public function branch()
	{
		return $this->hasMany('\App\Models\ConsigneeAddress', 'id', 'branch_id');
    }
    public function setGstinApplicableDateAttribute($value)
    {
        $this->attributes['gstin_applicable_date']= Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
    }
    public function getGstinApplicableDateAttribute($value)
    {
        $date = Carbon::parse($value);
        return $date->format('d/m/Y');
    }
}
