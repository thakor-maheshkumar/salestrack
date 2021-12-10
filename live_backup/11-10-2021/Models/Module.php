<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
	protected $table = 'modules';

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
        'slug',
    	'alias',
        'table',
        'is_default_module',
        'type',
        'parent_module',
        'status'
	];

    /**
     * Scope a query to only include active modules.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        $query->where('status', 1);
    }

    protected static function boot()
    {
        parent::boot();

        static::saved(function($model) {
            if ($model->isDirty('parent_module') && ($model->type == 1))
            {
                $module = $model->toArray();
                
                if(isset($module['table']) && !empty($module['table']))
                    $affected = \DB::table($module['table'])->update(['parent_unit' => NULL]);
            }
        });
    }

    /**
     * Define the relation between modules and module_relationship.
     *
     */
    public function module_relationships()
    {
        return $this->hasMany('App\Models\ModuleRelationship', 'module_id');
    }

    public function parent_unit_module()
    {
        return $this->belongsTo('App\Models\Module', 'parent_module', 'id');
    }
}
