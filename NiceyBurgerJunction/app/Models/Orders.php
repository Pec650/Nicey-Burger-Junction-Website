<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Orders extends Model
{
    protected $table = 'orders';
    
    protected $fillable = [
        'user_id',
        'product_id',
        'type',
        'quantity',
        'total_price',
        'request',
        'status',
        'payment_id',
    ];

    public function getPendingCount() {
        if (Auth::check()) {
            return self::where('user_id', Auth::id())
                        ->where('status', 'Pending')->sum('quantity');
        }
        return 0;
    }
}
