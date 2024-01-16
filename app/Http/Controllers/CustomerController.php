<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customer = Customer::all();
        return response()->json($customer, 200);
    }

    public function count()
    {
        $totalCustomers = Customer::count();
        return response()->json(['total_customers' => $totalCustomers], 200);
    }
}
