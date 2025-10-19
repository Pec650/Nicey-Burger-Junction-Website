<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use App\Models\Payments;

abstract class Controller
{
    protected function returnView($view)
    {
        $orders = new Orders();
        $order_count = $orders->getPendingCount();
        $ongoing = $orders->hasOngoingOrders();

        return view($view)
            ->with('order_count', $order_count)
            ->with('ongoing', $ongoing);
    }
}
