<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UnitData extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
	protected $table = 'units_data';

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
        'active'
	];
}
