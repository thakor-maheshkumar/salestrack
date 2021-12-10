<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PermissionScreen extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
	protected $table = 'permission_screens';

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
    	'name',
    	'create',
    	'edit',
    	'view',
    	'other',
    	'active'
	];

	/**
	 * Get active permission screen list.
	 *
	 * @param \Illuminate\Database\Eloquent\Builder $query
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function scopeActive($query)
	{
		return $query->where('active', 1);
	}
}
