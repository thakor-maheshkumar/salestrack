<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModuleRelationship extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
	protected $table = 'module_relationship';

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
    	'module_id',
    	'table',
        'table_column',
        'related_table',
        'related_table_column',
        'status'
	];

	/**
     * Define the relation between module_relationship and modules.
     *
     */
    public function module()
    {
        return $this->belongsTo('App\Models\Module', 'module_id', 'id');
    }
}
