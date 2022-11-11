<?php

namespace App\Http\Controllers;

use App\Models\Counter;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use Illuminate\Http\Request;
use Symfony\Component\Console\Input\Input;

class InvoiceController extends Controller
{
    public function get_invoice_list(){
        $data = Invoice::with('customer')->orderBy('id','DESC')->get();

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
            'date'=>null,
            'due_date'=>null,
            'reference'=>null,
            'discount'=>0,
            'terms_and_condition'=>'Default terms and conditions',
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

    public function add_invoice(Request $request){
        $invoiceitem = $request->input('invoice_item');

        $invoicedata['sub_total']= $request->input('subtotal');
        $invoicedata['total']= $request->input('total');
        $invoicedata['customer_id']= $request->input('customer_id');
        $invoicedata['number']= $request->input('number');
        $invoicedata['date']= $request->input('date');
        $invoicedata['due_date']= $request->input('due_date');
        $invoicedata['discount']= $request->input('discount');
        $invoicedata['reference']= $request->input('reference');
        $invoicedata['terms_and_condition']= $request->input('terms_and_condition');

        $invoice = Invoice::create($invoicedata);

        foreach(json_decode($invoiceitem) as $item){
            $itemdata['product_id'] = $item->id;
            $itemdata['invoice_id'] = $invoice->id;
            $itemdata['quantity'] = $item->quantity;
            $itemdata['unit_price'] = $item->unit_price;

            InvoiceItem::create($itemdata);

        }
    }
}
