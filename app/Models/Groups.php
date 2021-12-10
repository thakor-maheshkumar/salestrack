<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Groups extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
	protected $table = 'groups';

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
        'group_name',
        'under',
        'group_type',
        'group_details',
        'is_affect',
	];

    public function parentGroup()
    {
        return $this->hasOne('\App\Models\Groups', 'id', 'group_type');
    }

    public function underGroup()
    {
        return $this->hasOne('\App\Models\Groups', 'id', 'under');
    }
}
