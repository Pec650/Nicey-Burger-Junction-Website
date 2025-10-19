<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

    public static function getPendingCount()
    {
        if (Auth::check()) {
            return self::where('user_id', Auth::id())
                        ->where('status', 'Pending')->sum('quantity');
        }
        return 0;
    }

    public static function hasOngoingOrders()
    {
        if (Auth::check()) {
            $ongoing_count = self::where('user_id', Auth::id())
                                    ->where('status', 'Ongoing')
                                    ->count();
            return $ongoing_count > 0;
        }
        return false;
    }

    public static function removePendingOrders()
    {
        if (Auth::check()) {
            self::where('user_id', Auth::id())
                ->where('status', 'Pending')
                ->delete();
            DB::statement("ALTER TABLE orders AUTO_INCREMENT = 1");
        }
    }

    public static function turnoverPendingOrders($guest_id)
    {
        if (Auth::check()) {
            self::where('user_id', $guest_id)
                ->where('status', 'Pending')
                ->update(['user_id' => Auth::id()]);
        }
    }
}
