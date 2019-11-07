<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Validator;
use Illuminate\Http\Request;

class CustomerController extends Controller
{

    public function addCustomers(Request $request){
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required',
        ]);
        if($validator->fails()){
            return $this->fail($validator->errors(), $validator->messages()->first(), 'false', 401);
        }
        $input = $request->all();
        $customer = Customer::create($input);
        return $this->success($customer , "Add customer successful");
    }
}
