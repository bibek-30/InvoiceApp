<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Product;
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

    public function store(Request $request, $id)
    {
        $request->validate([
            'product_ids' => 'required|array',
            'product_ids.*' => 'exists:products,id',
            'quantities' => 'required|array',
            'quantities.*' => 'integer|min:1',
        ]);

        $customer = Customer::find($id);
        if (!$customer) {
            return response()->json("No Customer Found!", 400);
        }

        $invoice = Invoice::create([
            // 'invoice_no' => 'INV' . uniqid(),
            'invoice_date' => now(),
            'due_date' => now()->addDays(10),
            'status' => 'unpaid',
            'total_amount' => 0,
            'customer_id' => $customer->id,
        ]);

        foreach ($request->input('product_ids') as $key => $productId) {
            $product = Product::find($productId);

            $invoiceItem = $invoice->items()->create([
                'product_id' => $productId,
                'quantity' => $request->input('quantities')[$key],
                'subtotal' => $request->input('quantities')[$key] * $product->price,
            ]);

            $invoice->total_amount += $invoiceItem->subtotal;
        }
        $invoice->save();

        return response()->json(['message' => 'Successful!', 'invoice_id' => $invoice], 200);
    }


    public function edit(Request $request, $invoiceId)
    {
        $request->validate([
            'product_ids' => 'required|array',
            'product_ids.*' => 'exists:products,id',
            'quantities' => 'required|array',
            'quantities.*' => 'integer|min:1',
        ]);

        $invoice = Invoice::find($invoiceId);

        if (!$invoice) {
            return response()->json("Invoice not found!", 404);
        }

        // Delete existing items to replace them with the updated items
        $invoice->items()->delete();

        foreach ($request->input('product_ids') as $key => $productId) {
            $product = Product::find($productId);

            $invoiceItem = $invoice->items()->create([
                'product_id' => $productId,
                'quantity' => $request->input('quantities')[$key],
                'subtotal' => $request->input('quantities')[$key] * $product->price,
            ]);

            $invoice->total_amount += $invoiceItem->subtotal;
        }

        $invoice->save();

        return response()->json(['message' => 'Invoice updated successfully!', 'invoice_id' => $invoice->id], 200);
    }

    public function destroy($invoiceId)
    {
        $invoice = Invoice::find($invoiceId);

        if (!$invoice) {
            return response()->json("Invoice not found!", 404);
        }

        $invoice->items()->delete(); // Delete associated items first
        $invoice->delete(); // Delete the invoice

        return response()->json(['message' => 'Invoice deleted successfully!'], 200);
    }

    public function getInvoiceItems($invoiceId)
    {
        $invoice = Invoice::with('items')->find($invoiceId);

        if (!$invoice) {
            return response()->json("Invoice not found!", 404);
        }

        $invoiceItems = $invoice->items;

        return response()->json(['invoice_items' => $invoiceItems], 200);
    }


    public function getInvoicesForCustomer($customerId)
    {
        $customer = Customer::find($customerId);

        if (!$customer) {
            return response()->json("Customer not found!", 404);
        }

        $invoices = Invoice::with('items')->where('customer_id', $customerId)->get();

        return response()->json(['invoices' => $invoices], 200);
    }


}
