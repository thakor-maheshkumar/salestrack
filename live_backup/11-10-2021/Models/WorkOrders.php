<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkOrders extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
	protected $table = 'workorders';

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
        'voucher_no',
        'plan_id',
        'qc_id',
        'status',
        'qc_status',
        'active',
        'created_at',
        'updated_at',
        'suffix',
        'prefix',
        'number',
        'series_type'
    ];
    
    public function plan()
    {
        return $this->hasOne('\App\Models\ProductionPlan','id','plan_id');
    }
}
