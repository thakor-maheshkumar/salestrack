<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
class Transporter extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
	protected $table = 'transporters';

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
        'name',
        'tansporter_id',
        'gst_no',
        'doc_no',
        'doc_date',
        'active'
    ];
    
    public function setDocDateAttribute($value)
    {
        $this->attributes['doc_date']= Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
    }
    public function getDocDateAttribute($value)
    {
        $date = Carbon::parse($value);
        return $date->format('d/m/Y');
    }
}
