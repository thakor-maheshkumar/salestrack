<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
	protected $table = 'companies';

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
        'parent_unit',
        'name',
        'firm_type',
        'pan_no',
        'pan_applicable_date',
        'gst_no',
        'gst_reg_type',
        'gst_applicable_date',
        'dl_no',
        'dl_applicable_date',
        'dl_expiry_date',
        'fssai',
        'fssai_applicable_date',
        'fssai_expiry_date',
        'cin',
        'aadhar_no',
        'address',
        'street',
        'landmark',
        'city',
        'state',
        'country_id',
        'zipcode',
        'phone',
        'phone_1',
        'phone_2',
        'mobile_no',
        'fax',
        'email',
        'email_1',
        'website',
        'iec_code',
        'iec_applicable_date',
        'tan_no',
        'tan_date',
        'fiscal_start_date',
        'fiscal_end_date',
        'module_id',
        'active',
        'logo_image'
	];

    /**
     * Scope a query to only include active Company.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        $query->where('active', 1);
    }

    /**
     * Define the relation between country and company.
     */
    public function country()
    {
        return $this->belongsTo('\App\Models\Country', 'country_id', 'id');
    }

    /**
     * Define the relation between module and company.
     */
    public function module()
    {
        return $this->belongsTo('\App\Models\Module', 'module_id', 'id');
    }

    /**
     * Define the relation between module and company.
     */
    public function relationshipTree()
    {
    	return $this->morphOne('App\Models\RelationshipTree', 'imageable');
    }
}
