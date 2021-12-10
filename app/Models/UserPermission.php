<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
class UserPermission extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
	protected $table = 'user_permission';

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
    	'user_id',
    	'role_id',
        'role_permissions',
        'start_date',
    	'expiry_date'
	];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'role_permissions' => 'json',
    ];
    
	/**
     * Define the relation between roles and UserPermission.
     */
    public function role()
    {
        return $this->belongsTo('\App\Models\Role', 'role_id', 'id');
    }
    public function setStartDateAttribute($value)
    {
        $this->attributes['start_date']= Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
    }
    public function setExpiryDateAttribute($value)
    {
        $this->attributes['expiry_date']= Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
    }
}
