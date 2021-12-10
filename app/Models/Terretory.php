<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Terretory extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
	protected $table = 'terretories';

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
        'terretory_name',
        'under',
        'active'
	];

    public function parentGroup()
    {
        return $this->belongsTo('\App\Models\Terretory', 'under', 'id');
    }
}
