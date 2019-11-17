<?php

namespace App\Http\Controllers;

use App\orderHeader;
use App\OrderList;
use Illuminate\Http\Request;
use App\Item;
use Illuminate\Support\Arr;
use Illuminate\Support\MessageBag;
use mysql_xdevapi\Exception;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\OrderLists;
use Validator, Redirect, Response;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }


    public function getPrice($id)
    {
        $itemPrice = Item::find($id);
        return response()->json(['success' => true, 'html' => $itemPrice]);
    }


    public function saveOrder(Request $request)
    {
        try {
            $this->validate($request, [
                'data' => [
                    'itemPrice' => 'required',
                    'itemQuant' => 'required',
                    'totalPrice' => 'required'
                ]]);

            $order = new orderHeader;
            $itemQuant = 0;
            $totalAmount = 0;
            foreach ($request->data as $listItem) {
                $itemQuant += $listItem['itemQuant'];
                $totalAmount += $listItem['totalPrice'];
            }
            $order->order_number = 'order1';
            $order->customer = 'susindu';
            $order->delivery_address = 'matara';
            $order->total_item = $itemQuant;
            $order->total_amount = $totalAmount;

            $order->save();


            foreach ($request->data as $item) {
                $orderHeader = new OrderList;
                $itemObject = Item::where('item_name', $item['itemName'])->first();
                $orderHeader->order_id = $order['id'];
                $orderHeader->item_id = $itemObject['id'];
                $orderHeader->per_item_price = $itemObject['item_price'];
                $orderHeader->quantity = $item['itemQuant'];
                $orderHeader->total_price = $item['totalPrice'];

                $orderHeader->save();

                $arr = array('msg' => 'Contact Added Successfully!', 'status' => true);
                return Response()->json($arr);
            }
        } catch (ValidationException $e) {

            DB::rollBack();

            $arr = array('msg' => 'Something went wrong. Please try again!', 'status' => false);
            return Response()->json($arr);

        } catch (Exception $e) {

        }


    }

    public function addToCart(Request $request)
    {
        try {
            $this->validate($request, [
                'data' => [
                    'tprice' => 'required',

                ]]);

            $quant = 0;
            $price = 0;

            foreach ($request->data as $orderList) {
                $orderItemNames [] = $orderList['tname'];

            }

            $orderItemName = collect($orderItemNames);
            $uniqueNames = $orderItemName->unique();
            foreach ($uniqueNames as $uniqueName) {

                foreach ($request->data as $orderList) {
                    $collection = collect($orderList);
                    if ($collection->search($uniqueName) == true) {

                        $price = $collection['tprice'];
                        $quant += $collection['tquant'];
                    }
                }
                $list [] = Arr::add(['itemName' => $uniqueName, 'itemPrice' => $price, 'itemQuant' => $quant], 'totalPrice', $price * $quant);
                $quant = 0;
            }

            return response()->json(['success' => true, 'html' => $list]);

        } catch (ValidationException $e) {

            $arr = array('msg' => 'Something went wrong. Please try again!', 'status' => false);
            return Response()->json($arr);
        } catch (Exception $e) {

        }

    }
}
