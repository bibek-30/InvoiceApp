<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::all();
        return response()->json($invoices, 200);
    }

    public function singleProduct($id)
    {
        $invoice = Invoice::find($id);

        if (!$invoice) {
            return response()->json(["message" => "invoice not found"], 404);
        }

        return response()->json($invoice, 200);
    }

    public function create(Request $request)
    {
        $validatedData = $request->validate([
            // 'invoice_no' => 'required',
            'invoice_date' => 'required|date',
            'due_date' => 'required|date',
            'customer_id' => 'required|exists:customers,id',
            'total_amount' => 'required|numeric|min:0',
            'status' => 'required|in:paid,unpaid',
        ]);

        $invoice = Invoice::create($validatedData);

        return response()->json($invoice,200);
    }

    public function destroy($id)
    {
        $invoice = Invoice::findOrFail($id);
        if (!$invoice) {
            return response()->json(["message" => "Invoice not found"], 404);
        }

        $invoice->delete();

        return response()->json("Invoice Deleted Succesfully!",201);

    }

}
