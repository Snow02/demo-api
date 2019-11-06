<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Validator;
use Carbon\Carbon;

class OrderController extends Controller
{

    public function addOrder(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'customer_id' => 'exists:customers,id',
                'article_id' =>'exists:articles,id',

            ]);
            if ($validator->fails()) {
                return $this->fail($validator->errors(), $validator->messages()->first(), 'false', 401);
            }
            $order = Order::create([
                'customer_id' => $request->get('customer_id'),
                'status' => $request->get('status'),
                'date_hire' => Carbon::now(),
            ]);
            if ($order) {
                if ($request->has('articles')){
                    $articles = json_decode($request->articles);
                    foreach ($articles as $article) {

                        $order->articles()->attach($article->id, array('price' => $article->price));
                    }
                }

                if($request->has('article_id')){
                    $order->articles()->attach($request->article_id,array('price' => $request->get('price')) );
                }

                return $this->success($order, "Add Order Successful");
            }
        } catch (\Exception $e) {
            return $this->error($e);
        }
    }

    public function getOrderByCustomerId($id)
    {
        try {

            $list_orders = Order::whereCustomerId($id)->get();
            $new_list_orders = [];
            if ($list_orders) {
                foreach ($list_orders as $order) {
                    $customer = $order->customer()->get();
                    foreach ($order->articles as $article) {
                        $new_articles = [];
                        $new_articles[] = ['id' => $article->id, 'title' => $article->title, 'price' => $article->pivot->price];
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

    public function getOrderHavePaid(Request $request)
    {
        try {
            $orders = Order::where('status', 1)->get();
            return $this->success($orders, ' The orders has been successfully paid ');
        } catch (\Exception $e) {
            return $this->error($e);
        }
    }

    public function getOrderByDate(Request $request)
    {
        try {
            $orders = Order::with('articles')->whereDate('created_at', $request->date)->get();
//            $orders = Order::whereDate('created_at','>=',$request->date)->get();

            return $this->success($orders, "Order date {$request->date}");
        } catch (\Exception $e) {
            return $this->error($e);
        }
    }

    public function DeleteOrder(Request $request)
    {
        try {
            $order = Order::findOrFail($request->id);
            foreach ($order->articles as $article) {
                $article_id = $article->id;
                $order->articles()->detach($article_id);
            }
            $order->delete();
            return $this->success($order, 'Delete Success');
        } catch (\Exception $e) {
            return $this->error($e);
        }
    }

    public function updateOrderById(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'customer_id' => 'required|exists:customers,id',
                'article_id' => 'required|exists:articles,id',
                'price' => 'required',
            ]);
            if ($validator->fails()) {
                return $this->fail($validator->errors(), $validator->messages(), 'Failer', 401);
            }
            $order = Order::findOrFail($request->id);
            $order->update([
                'customer_id' => $request->get('customer_id'),
                'date_hire' => Carbon::now(),
            ]);
            if ($order) {
                if ($request->has('article_id')) {
                    foreach ($order->articles as $article) {
                        $order->articles()->updateExistingPivot($article->id, ['article_id' => $request->get('article_id'), 'price' => $request->get('price')]);
                    }
                }
            }
            return $this->success($order, "Update Success");
        } catch (\Exception $e) {
            return $this->error($e);
        }
    }

    public function updateOrderByCustomerId(Request $request){
        try{
            $validator = Validator::make($request->all(),[
               'article_id' => 'exists:articles,id'
            ]);
            if($validator->fails()){
                return $this->fail($validator->errors(),$validator->messages()->first(), 'Fail', 401);
            }
            $orders = Order::where('customer_id',$request->customer_id)->get();
            if($orders){
                foreach($orders as $order){
                    $order->update([
                        'status'=> $request->get('status'),
                    ]);
                    if($request->has('articles')){
                        foreach($order->articles as $art){
                            $articles = json_decode($request->articles);
                            foreach($articles as $article){
                                $order->articles()->updateExistingPivot($art->id, ['article_id'=>$article->id,'price'=> $article->price]);
                            }
                        }

                    }
                    if($request->has('article_id')){
                        foreach($order->articles as $article){
                            $order->articles()->updateExistingPivot($article->id , ['article_id'=>$request->article_id, 'price'=>$request->price]);
                        }
                    }

                }
                return $this->success($orders,'Update SuccessFul');
            }

        }catch(\Exception $e){
            return $this->error($e);
        }

    }






}
