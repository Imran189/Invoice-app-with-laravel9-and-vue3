<?php

namespace App\Http\Controllers;

use App\Models\Counter;
use App\Models\Customer;
use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function get_invoice_list(){
        $data= Invoice::with('customer')->orderBy('id','DESC')->get();

        return response()->json([
            'invoices'=>$data
        ],200);
    }
    public function search_invoice(Request $request){
        $search = $request->get('s');
        if($search != null){
            $invoice =Invoice::with('customer')->where('id','LIKE',"%$search%")->get();
            return response()->json([
                'invoices'=>$invoice
            ],200);
        }else{
            return $this->get_invoice_list();
        }
    }

    public function create_invoice(Request $request){
        $counter = Counter::where('key', 'invoice')->first();
        $random = Counter::where('key', 'invoice')->first();

        $invoice = Invoice::orderBy('id','DESC')->first();
        if($invoice){
            $invoice = $invoice->id+1;
            $counter = $counter->value;
        }else{
            $counter = $counter->value;
        }
    }
}
