<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkorderQcReport extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
	protected $table = 'workorder_qc_reports';

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
        'work_order_id',
        'grade_id',
        'plan_id',
        'qc_id',
        'stock_item_id',
        'product_name',
        'ar_no',
        'reset_date',
        'remarks',
        'active'
    ];

    public function stockItems()
	{
		return $this->belongsTo('\App\Models\StockItem', 'stock_item_id');
    }

    public function grades()
	{
		return $this->belongsTo('\App\Models\Grades', 'grade_id');
    }

    public function qc()
	{
		return $this->belongsTo('\App\Models\Qc', 'qc_id');
    }

    public function qc_workorder_test_reports()
    {
        return $this->hasMany('\App\Models\QcWorkorderTestReport', 'qc_report_id');
    }

    public function workOrder()
    {
        return $this->belongsTo('\App\Models\WorkOrders', 'work_order_id');
    }
}
