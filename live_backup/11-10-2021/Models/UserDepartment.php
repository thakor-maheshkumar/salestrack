<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class UserDepartment extends Pivot
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
	protected $table = 'user_department';

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
	 * Indicates if the IDs are auto-incrementing.
	 *
	 * @var bool
	 */
	public $incrementing = true;

    /**
     * fillable column name goes here
     *
     * @var array
     */
    protected $fillable = [
    	'id',
        'user_id',
        'department_id',
        'start_date',
        'end_date',
        'is_manager'
	];

	/**
     * Get the formatted date
     *
     */
    public function getStartDateAttribute($date)
    {
        return \Carbon\Carbon::parse($date)->format('Y-m-d');
    }

    /**
     * Get the formatted date
     *
     */
    public function getEndDateAttribute($date)
    {
        return \Carbon\Carbon::parse($date)->format('Y-m-d');
    }
}
