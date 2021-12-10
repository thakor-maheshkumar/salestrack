<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockItem extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
	protected $table = 'stock_items';

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
        'name',
        'product_descriptiopn',
        'under',
        'unit_id',
        'convertion_rate',
        'shipper_pack',
        'alternate_unit_id',
        'part_no',
        'product_image',
        'category_id',
        'is_allow_mrp',
        'is_allow_part_number',
        'is_maintain_in_batches',
        'track_manufacture_date',
        'use_expiry_dates',
        'is_gst_detail',
        'taxability',
        'is_reverse_charge',
        'tax_type',
        'rate',
        'applicable_date',
        'cess',
        'cess_applicable_date',
        'supply_type',
        'hsn_code',
        'default_warehouse',
        'opening_stock',
        'maintain_stock',
        'product_code',
        'cas_no',
        'pack_code',
        'active'
	];

    public function group()
    {
        return $this->belongsTo('\App\Models\StockGroup', 'under', 'id');
    }

    public function category()
    {
        return $this->belongsTo('\App\Models\StockGroup', 'category_id', 'id');
    }

    public function warehouse()
    {
        return $this->belongsTo('\App\Models\StockGroup', ' default_warehouse', 'id');
    }

    public function InventoryUnit()
    {
        return $this->belongsTo('\App\Models\InventoryUnit', 'unit_id', 'id');
    }
    
    public function unit()
    {
        return $this->belongsTo('\App\Models\InventoryUnit', 'unit_id', 'id');
    }

    public function alternate_unit()
    {
        return $this->belongsTo('\App\Models\InventoryUnit', 'alternate_unit_id', 'id');
    }

    public function stock_item_grades()
    {
        return $this->hasMany('\App\Models\StockItemGrades', 'stock_item_id', 'id')->where('active',1);
    }
    public function stock_category()
    {
        return $this->belongsTo('\App\Models\StockCategory', 'category_id', 'id');
    }
}
