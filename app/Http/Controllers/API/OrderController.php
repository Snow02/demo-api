<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Validator;
use Carbon\Carbon;

class OrderController extends Controller
{

    public function addOrderByCustomer(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'customer_id' => 'exists:customers,id',
                'article_id' => 'required|exists:articles,id',
            ]);
            if ($validator->fails()) {
                return $this->fail($validator->errors(), $validator->messages()->first(), 'false', 401);
            }
            $order = Order::create([
                'customer_id' => $request->get('customer_id'),
                'status' => 0,
                'date_hire' => Carbon::now(),
            ]);
            if ($order) {
                if ($request->has('article_id')) {
                    foreach ($request->article_id as $article_id) {
                        $order->articles()->attach($article_id, array('price' => $request->get('price')));
                    }
                }
                return $this->success($order, "add Order Successfull");
            }
        } catch (\Exception $e) {
            return $this->error($e);
        }
    }

    public function getOrderByCustomerId($id)
    {
        try {

            $list_orders = Order::whereCustomerId($id)->with('articles')->get();

            $new_list_orders = [];
            if ($list_orders) {
                foreach ($list_orders as $order) {
                    $customer = [];
                    if($order->customers){
                        $customer = $order->customers->get();
                    }
                    foreach ($order->articles as $article) {
                        $new_articles = [];

                        $new_articles[] = ['id' => $article->id, 'price' => $article->pivot->price];
                        $new_list_orders[] = [
                            'id' => $order->id,
                            'customer_id' => $order->customer_id,
                            'status' => $order->status,
                            'date_hire' => $order->date_hire,
                            'articles' => $new_articles,
                            'customer' => $customer,
                        ];
                    }
                }
            }
            return $this->success($new_list_orders, "List Orders");
        } catch (\Exception $e) {
            return $this->error($e);
        }
    }
}
