<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RelationshipTree extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
	protected $table = 'relationship_tree';

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
        'module',
        'module_id',
        'relationship_type',
        'relationship_module',
        'relationship_module_id',
        'start_date',
        'end_date',
        'changed_on',
        'acted_user'
	];

    /**
     * Define the relation between user and relationship_tree.
     */
    public function user()
    {
        return $this->belongsTo('\App\Models\User', 'acted_user', 'user_id');
    }

    /**
     * Define the relation between module and relationship_tree.
     */
    public function module()
    {
        return $this->belongsTo('\App\Models\Module', 'module', 'alias');
    }

	/**
     * Define the relation between relationship_module and relationship_tree.
     */
    public function relationship_module()
    {
        return $this->belongsTo('\App\Models\Module', 'relationship_module', 'alias');
    }

	/**
     * Define the relation between relationship_type and relationship_tree.
     */
    public function relationship_type()
    {
        return $this->belongsTo('\App\Models\RelationhipType', 'relationship_type', 'id');
    }
}
