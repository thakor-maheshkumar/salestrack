<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grades extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
	protected $table = 'grades';

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
        'grade_name',
        'active'
    ];
    
    public function stockGrades()
	{
		return $this->hasMany('\App\Models\StockItemGrades', 'id', 'grade_id');
    }

}
