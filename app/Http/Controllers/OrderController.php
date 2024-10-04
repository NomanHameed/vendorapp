<?php

namespace App\Http\Controllers;

use App\Classes\TrackPOD;
use App\Models\Order;
use App\Models\OrderBillingAddress;
use App\Models\OrderCustomer;
use App\Models\OrderItem;
use App\Models\OrderShippingAddress;
use App\Models\Store;
use App\Models\Shopify;
use Illuminate\Http\Request;
use App\AppHelper;

class OrderController extends Controller
{

    /**
     * @param Request $request
     * @return Application|Factory|View
     */
    public function index(Request $request)
    {
        $request = AppHelper::getAppRequests($request);
        $store_id = strval(trim($request['store_id']));
        $totalOrders = Order::whereStoreId($store_id)->count();
        return view('orders.index', compact('request', 'totalOrders'));
    }


    /**
     * Create-Order web Hooks
     */
    public function createForWebHook()
    {
        // $order = json_decode(file_get_contents('order.json'), true);
        $domain = $_SERVER['HTTP_X_SHOPIFY_SHOP_DOMAIN'];
        // $domain = 'bechic-ie.myshopify.com'; // 
        $order = json_decode(file_get_contents('php://input'), true);
        $storeQuery =  Store::whereDomain($domain);
        if ($storeQuery->exists()) {
            $store = $storeQuery->first();

            Order::manageOrder($order, $store);

            $_order = json_decode(file_get_contents('php://input'));
            $this->createOrder($_order);
        }
    }

    /**
     * Create-Order
     */
    public function createOrder($order)
    {
        $shiping = $order->shipping_address;
        $customer = $order->customer;
        $address = $shiping->address1;
        $address .= !empty($shiping->address2) ? ', ' . $shiping->address2 : '';
        $address .= !empty($shiping->province) ? ', ' . $shiping->province : '';
        $address .= ', ' . $shiping->city;
        $address .= ', ' . $shiping->zip;

        $order_array = [
            "Id"            => strval($order->id),
            "Number"            => $order->name,
            "Date"          => date('Y-m-d'),
            "Type"             => 0,
            "Client"   => $customer->first_name,
            "Address"  => $address,
            "ContactName"            => $shiping->name,
            "Phone"        => $shiping->phone,
            "Email"             => $order->email
        ];
        foreach ($order->line_items as  $line_item) {
            $order_array['GoodsList'][] = [
                'GoodsName' => str_replace('"', " ", $line_item->name),
                'Quantity'  => strval($line_item->quantity),
                'Cost'      => $line_item->price,
                'Note'      => $line_item->sku
            ];
        }

        // print_r(json_encode($order_array));
        // dd($order_array);

        $trackpod = new TrackPOD();
        $result = $trackpod->postOrder($order_array);
        // echo(json_encode($result));

        if ($result->Status == '201') {
            Order::where('order_id', strval($order->id))->update(['trackpod_posted' => 1]);
        }

        return $result;
    }



    /**
     * Create-Order web Hooks
     */
    public function updateForWebHook()
    {
        $order = json_decode(file_get_contents('php://input'), true);
        $storeQuery = Store::whereDomain($_SERVER['HTTP_X_SHOPIFY_SHOP_DOMAIN']);
        if ($storeQuery->exists()) {
            $store = $storeQuery->first();
            Order::manageOrder($order, $store);
        }
    }

    /**
     * Delete-Order web Hooks
     */
    public function deleteForWebHook()
    {
        file_put_contents('delete_order.txt', 'Please delete Me');
        $order_id = json_decode(file_get_contents('php://input'), true)['id'];
        $storeQuery = Store::whereDomain($_SERVER['HTTP_X_SHOPIFY_SHOP_DOMAIN']);
        if ($storeQuery->exists()) {

            $store = $storeQuery->first();
            $orderId = strval(trim($order_id));
            $storeId = strval(trim($store->store_id));

            Order::where('order_id', $orderId)->where('store_id', $storeId)->delete();
            OrderItem::where('order_id', $orderId)->where('store_id', $storeId)->delete();
            OrderShippingAddress::where('order_id', $orderId)->where('store_id', $storeId)->delete();
            OrderBillingAddress::where('order_id', $orderId)->where('store_id', $storeId)->delete();
            OrderCustomer::where('order_id', $orderId)->where('store_id', $storeId)->delete();
            OrderItem::where('order_id', $orderId)->where('store_id', $storeId)->delete();
        }
    }


    /**
     * Sync Orders to local database
     * @param Request $request
     * @return array
     */
    public function sync(Request $request): array
    {
        $json = array();
        $storeId = $request->get('store_id');
        $store = Store::whereStoreId($storeId)->first();
        Order::sync($store);

        $postedArray = array();
        $data = Order::leftJoin('order_customers as order_customer', 'orders.order_id', '=', 'order_customer.order_id')
            ->leftJoin('order_items as order_item', 'order_item.order_id', '=', 'orders.order_id')
            ->leftJoin('order_billing_addresses as order_billing_address', 'order_billing_address.order_id', '=', 'orders.order_id')
            ->leftJoin('order_shipping_addresses  as order_shipping_address', 'order_shipping_address.order_id', '=', 'orders.order_id')
            ->where('orders.store_id', $storeId)
            ->get()
            ->toArray();
        $fields = StoreActiveField::whereStoreId($storeId)->whereType('orders')->whereActive(true)->pluck('value')->toArray();
        foreach ($data as $key => $d) {
            $finalArray = array_filter(
                (array)$d,
                function ($key) use ($fields) {
                    return in_array($key, $fields);
                },
                ARRAY_FILTER_USE_KEY
            );
            /*Manage Headings*/
            if ($key === array_key_first($data)) {
                $headings = array();
                foreach (array_keys($finalArray) as $heading) {
                    array_push($headings, ucwords(str_replace('_', ' ', $heading)));
                }
                array_push($postedArray, $headings);
            }
            array_push($postedArray, array_values($finalArray));
        }
        if ($response == true) {
            $json['type'] = 'success';
        } else {
            $json['type'] = 'error';
        }
        return $json;
    }

    public function addOrder(Request $request)
    {

        $order_id = $request->query('order_id');
        $shop = $request->query('shop');
        $store = Store::where('domain', $shop)->first();


        echo '<pre>';

        $end_point = "orders/" . $order_id;
        $request = Shopify::call($store->token, $store->domain, $end_point);
        $order = json_decode(json_encode($request['order']));
        // $json_res = json_decode($request['response']);
        // dd($json_res->order);
        dd($this->createOrder($order));
    }
}
