<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class WebHook extends Model
{

    protected $table = 'web_hooks';
    protected $fillable = [
        'store_id', 'name', 'webhook_id', 'address'
    ];

    /**
     * Create Customer - WebHook
     * @param $store
     */
    public static function createCustomer($store)
    {
        $data = array(
            'webhook' =>
                array(
                    'topic' => 'customers/create',
                    'address' => env('PUBLIC_APP_URL') . "webhooks/customers/create",
                    'format' => 'json'
                )
        );
        self::call($store, $data, 'customers/create');
    }

    


    /**
     * Create Order - WebHook
     * @param $store
     */
    public static function createOrder($store)
    {
        $data = array(
            'webhook' =>
                array(
                    'topic' => 'orders/create',
                    'address' => env('PUBLIC_APP_URL') . "webhooks/orders/create",
                    'format' => 'json'
                )
        );
        self::call($store, $data, 'orders/create');
    }

    /**
     * Update Order - WebHook
     * @param $store
     */
    public static function updateOrder($store)
    {
        $data = array(
            'webhook' =>
                array(
                    'topic' => 'orders/updated',
                    'address' => env('PUBLIC_APP_URL') . "webhooks/orders/update",
                    'format' => 'json'
                )
        );
        self::call($store, $data, 'orders/updated');
    }

    /**
     * Delete Order - WebHook
     * @param $store
     */
    public static function deleteOrder($store)
    {
        $data = array(
            'webhook' =>
                array(
                    'topic' => 'orders/delete',
                    'address' => env('PUBLIC_APP_URL') . "webhooks/orders/delete",
                    'format' => 'json'
                )
        );
        self::call($store, $data, 'orders/delete');
    }

    /**
     * Delete Customer - WebHook
     * @param $store
     */
    public static function deleteCustomer($store)
    {
        $data = array(
            'webhook' =>
                array(
                    'topic' => 'customers/delete',
                    'address' => env('PUBLIC_APP_URL') . "webhooks/customers/delete",
                    'format' => 'json'
                )
        );
        self::call($store, $data, 'customers/delete');
    }

    /**
     * @param $store
     * @param $data
     * @param $name
     */
    public static function call($store, $data, $name)
    {
        $end_point = "webhooks";
        $response = Shopify::call($store->token, $store->domain, $end_point, $data, 'POST');
        
        if (isset($response['webhook'])) {
            $webHookModel = new WebHook();
            $webHookModel->name = $name;
            $webHookModel->webhook_id = strval($response['webhook']['id']);
            $webHookModel->store_id = strval(trim($store->store_id));
            $webHookModel->address = $response['webhook']['address'];
            $webHookModel->save();
        }
    }
}
