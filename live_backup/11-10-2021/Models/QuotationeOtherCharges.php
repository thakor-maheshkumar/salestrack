<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuotationeOtherCharges extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'quotatione_other_charges';
    protected $guarded = ['quotatione_other_charges'];
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
        return $this->hasOne('\App\Models\StockItem', 'id', 'stock_item_id');
    }

    public function quotation()
    {
        return $this->belongsTo('\App\Models\Quotation', 'quotation_id');
    }
}
