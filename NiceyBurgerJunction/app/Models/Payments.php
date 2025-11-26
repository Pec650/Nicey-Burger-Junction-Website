<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payments extends Model
{
    protected $table = 'payment';
    
    protected $fillable = [
        'user_id',
        'address_id',
        'total_payment',
        'total_quantity',
        'remarks',
        'branch_id',
        'cancel_reason'
    ];
}
