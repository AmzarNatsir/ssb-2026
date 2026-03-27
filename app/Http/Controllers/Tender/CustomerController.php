<?php

namespace App\Http\Controllers\Tender;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tender\Customer;


class CustomerController extends Controller
{
    public function index(){
        return view('Tender.customer.index');
    }

    public function simpan_customer(Request $request){

        $simpan = Customer::create([
            "customer_no" => uniqid(),
            "customer_name" => $request->input('customer_name'),
            "customer_address" => $request->input('customer_address'),
            "contact_person_name" => $request->input('contact_person_name'),
            "contact_person_number" => str_replace(' ','',$request->input('contact_person_number'))
        ]);

        if($simpan){
            return response()->json('sukses', 200);
        } else {
            return response()->json('error', 404);
        }
    }

    public function list(){
        $customer = Customer::all();
        return view('Tender.customer.list',['customer'=>$customer]);
    }

    public function customer($id){
        $customer = Customer::find($id);
        return response()->json([
            'message' => 'Get Customer success.',
            'customer' => $customer
        ]);
    }
}
