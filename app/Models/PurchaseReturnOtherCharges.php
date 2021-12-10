<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseReturnOtherCharges extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'purchase_return_other_charges';
    protected $guarded = ['purchase_return_other_charges'];
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

    protected $touches = ['purchase_return'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function($model){
            if($user_id = \Sentinel::getUser()->id)
            {
                $model->purchase_return->edited_by = $user_id;
                $model->purchase_return->save();
            }
        });

        static::updating(function($model){
            if($user_id = \Sentinel::getUser()->id)
            {
                $model->purchase_return->edited_by = $user_id;
                $model->purchase_return->save();
            }
        });
    }

    public function purchase_return()
    {
        return $this->belongsTo('\App\Models\PurchaseReturn', 'purchase_return_id');
    }
}
