<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConsigneeAddress extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
	protected $table = 'consignee_addresses';

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
        'ledger_id',
        'ledger_type',
        'branch_name',
		'address',
		'city',
		'state',
		'pincode',
		'location',
		'mobile_no',
		'landline_no',
		'fax_no',
		'website'
	];

    public function territory()
	{
		return $this->hasOne('\App\Models\Terretory', 'id', 'location');
	}
}
