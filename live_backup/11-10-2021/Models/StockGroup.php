<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockGroup extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
	protected $table = 'stock_group';

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
        'is_gst_detail',
        'taxability',
        'is_reverse_charge',
        'gst_rate',
        'gst_applicable_date',
        'cess_rate',
        'cess_applicable_date',
        'active'
	];

    public function parentGroup()
    {
        return $this->belongsTo('\App\Models\StockGroup', 'under', 'id');
    }
}
