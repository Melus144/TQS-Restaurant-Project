<?php

namespace App\Admin\Orders\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

class OrderController extends Controller
{
    /*
    public function index(): View
    {
        return view('admin.orders.index');
    }

    public function orderLines(Order $order)
    {
        return view('admin.orders.show', ['order' => $order]);
    }
*/
    public function seed_bd()
    {
        \Artisan::call('db:seed');

    }


}
