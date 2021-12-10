<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QcReports extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
	protected $table = 'qc_reports';

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
        'purchase_receipt_id',
        'grade_id',
        'batch_id',
        'qc_id',
        'stock_item_id',
        'receipt_no',
        'product_name',
        'ar_no',
        'reset_date',
        'remarks',
        'warehouse_id',
        'active',
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

    public function qc_test_reports()
	{
		return $this->hasMany('\App\Models\QcTestReports', 'qc_report_id');
    }

    public function purchase_receipt()
    {
        return $this->belongsTo('\App\Models\PurchaseReceipt', 'purchase_receipt_id');
    }

    public function batch()
    {
        return $this->belongsTo('\App\Models\Batch', 'batch_id');
    }
}
