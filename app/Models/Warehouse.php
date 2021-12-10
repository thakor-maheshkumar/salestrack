<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
	protected $table = 'warehouse';

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
        'parentable_id',
        'parentable_type',
        'name',
        'address',
        'street',
        'landmark',
        'city',
        'state',
        'country_id',
        'email',
        'phone',
        'module_id',
        'active'
	];
	
    /**
     * Get the owning parentable model.
     */
    public function parentable()
    {
        return $this->morphTo();
    }
    
    /**
     * Scope a query to only include active warehouse.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        $query->where('active', 1);
    }

    /**
     * Define the relation between country and warehouse.
     */
    public function country()
    {
        return $this->belongsTo('\App\Models\Country', 'country_id', 'id');
    }

    /**
     * Define the relation between module and warehouse.
     */
    public function module()
    {
        return $this->belongsTo('\App\Models\Module', 'module_id', 'id');
    }
}
