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
            $counters = $counter->value;
        }else{
            $counters = $counter->value;
        }

        $formData=[
            'number'=>$counter->prefix.$counters,
            'customer_id'=>null,
            'customer'=>null,
            'date'=>date('Y-m-d'),
            'due_date'=>null,
            'reference'=>null,
            'discount'=>0,
            'terms and condition'=>'Default terms and conditions',
            'item'=>[
                [
                   'product_id'=>null,
                   'product'=>null,
                   'unit_price'=>0,
                   'quantity'=>1 
                ]
            ]
                ];

                return response()->json($formData);
    }
}
