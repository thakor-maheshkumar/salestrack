<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class PurchaseInvoiceSeries extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table='purchase_invoice_series';
}
