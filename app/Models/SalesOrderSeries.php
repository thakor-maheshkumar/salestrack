<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SalesOrderSeries extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table='sales_orders_series';
}
