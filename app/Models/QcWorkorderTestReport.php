<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QcWorkorderTestReport extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
	protected $table = 'qc_workorder_test_reports';

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
        'qc_report_id',
        'qc_test_id',
        'test_result',
        'remarks',
        'active'
    ];

    public function qc_test()
	{
		return $this->hasOne('\App\Models\QcTests', 'id', 'qc_test_id');
    }
}
