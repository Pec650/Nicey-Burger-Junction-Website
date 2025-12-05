<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payments extends Model
{
    use HasFactory;
    
    // ENSURE THIS IS 'payment' (Singular)
    protected $table = 'payment';

    protected $fillable = [
        'user_id',
        'total_payment',
        'total_quantity',
        'branch_id',
        'remarks',       // This MUST be here for the customer update to work
        'cancel_reason',
        'payment_id'
    ];
}