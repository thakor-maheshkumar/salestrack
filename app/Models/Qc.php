<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Qc extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
	protected $table = 'qc';

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
        'id',
        'stock_item_id',
        'grade_id',
        'casr_no',
        'molecular_formula',
        'molecular_weight',
        'spec_no',
        'characters',
        'storage_condition',
        'remarks',
        'active'
    ];
    
    /*public function qc()
	{
		return $this->belongsTo('\App\Models\QcTests', 'qc_id');
    }*/
    
    public function stockItems()
	{
		return $this->belongsTo('\App\Models\StockItem', 'stock_item_id');
    }

    public function grades()
	{
		return $this->belongsTo('\App\Models\Grades','grade_id');
    }

    public function grading()
	{
		return $this->hasMany('\App\Models\Grades','id');
    }

    /**
     * The stock items that belong to the bom.
     */
    public function qc_items()
    {
        return $this->hasMany('\App\Models\QcTests')->where('active',1);
    }
}
