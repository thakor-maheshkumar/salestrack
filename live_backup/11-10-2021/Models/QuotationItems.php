<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuotationItems extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'quotation_items';
    protected $guarded = ['quotation_items'];
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

    protected $touches = ['quotation'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function($model){
            if($user_id = \Sentinel::getUser()->id)
            {
                $model->quotation->edited_by = $user_id;
                $model->quotation->save();
            }
        });

        static::updating(function($model){
            if($user_id = \Sentinel::getUser()->id)
            {
                $model->quotation->edited_by = $user_id;
                $model->quotation->save();
            }
        });
    }

    public function stock_items()
    {
        return $this->belongsTo('\App\Models\StockItem', 'stock_item_id');
    }

    public function quotation()
    {
        return $this->belongsTo('\App\Models\Quotation', 'quotation_id');
    }
}
