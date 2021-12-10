<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalesReturnOtherCharges extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sales_return_other_charges';
    protected $guarded = ['sales_return_other_charges'];
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

    protected $touches = ['sales_return'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function($model){
            if($user_id = \Sentinel::getUser()->id)
            {
                $model->sales_return->edited_by = $user_id;
                $model->sales_return->save();
            }
        });

        static::updating(function($model){
            if($user_id = \Sentinel::getUser()->id)
            {
                $model->sales_return->edited_by = $user_id;
                $model->sales_return->save();
            }
        });
    }

    public function sales_return()
    {
        return $this->belongsTo('\App\Models\SalesReturn', 'sales_return_id');
    }
}
