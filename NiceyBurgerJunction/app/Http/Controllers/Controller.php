<?php

namespace App\Http\Controllers;

use App\Models\Orders;

abstract class Controller
{
    protected function returnView($view)
    {
        $orders = new Orders();
        $order_count = $orders->getPendingCount();
        return view($view)
            ->with('order_count', $order_count);
    }
}
