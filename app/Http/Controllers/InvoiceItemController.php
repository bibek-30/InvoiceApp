<?php

namespace App\Http\Controllers;


use App\Models\InvoiceItem;

class InvoiceItemController extends Controller
{
    public function index()
    {
        $items = InvoiceItem::all();
        return response()->json($items, 200);
    }

   
}
