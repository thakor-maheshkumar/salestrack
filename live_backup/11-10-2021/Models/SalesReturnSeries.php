<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SalesReturnSeries extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table='sales_return_series';
}
