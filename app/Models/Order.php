<?php

namespace App\Models;

use App\AppHelper;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    protected $fillable = [
        'store_id',
        'order_id',
        'order_number',
        'total_price',
        'subtotal_price',
        'total_weight',
        'total_tax',
        'currency',
        'financial_status',
        'total_discounts',
        'total_line_items_price',
        'trackpod_posted',
        'object'
    ];

    function getObjectProperty() {
        return json_decode($this->object);
    }

    function getPaymentMethodProperty() {
        return json_decode($this->object)->payment_gateway_names;
    }

    function getShippingAddressProperty() {
        return json_decode($this->object)->shipping_address;
    }
    function getBillingAddressProperty() {
        return json_decode($this->object)->billing_address;
    }


    public static function manageOrder($order, $store)
    {
        $store_id = strval($store->store_id);
        //$orderId = strval($order->id);
        $order_id = strval($order['id']);
        $orderData = [
            'store_id' => $store_id,
            'order_id' => $order_id,
            'order_number' => $order['name'],
            'subtotal_price' => $order['subtotal_price'],
            'total_price' => $order['total_price'],
            'total_price_usd' => $order['total_price_usd'],
            'total_weight' => $order['total_weight'],
            'total_tax' => $order['total_tax'],
            'currency' => $order['currency'],
            'financial_status' => $order['financial_status'],
            'fulfillment_status' => $order['fulfillment_status'],
            'total_discounts' => $order['total_discounts'],
            // 'tax_lines' => json_encode($order['tax_lines']) ?? null,
            // 'discount_applications' => json_encode($order['discount_applications']) ?? null,
            // 'discount_codes' => json_encode($order['discount_codes']) ?? null,
            // 'total_line_items_price' => $order['total_line_items_price'],
            // 'note_attributes' => json_encode($order['note_attributes']) ?? null,
            // 'client_details' => json_encode($order['client_details']) ?? null,
            // 'payment_gateway_names' => json_encode($order['payment_gateway_names']) ?? null,
            'object' => json_encode($order),
            'note' => $order['note'],
            'processing_method' => $order['processing_method'] ?? null,
            'checkout_id' => strval($order['checkout_id']),
            'source_name' => $order['source_name'],
            'contact_email' => $order['contact_email'],
            'reference' => $order['reference'],
            'confirmed' => $order['confirmed'],
            'cancel_reason' => $order['cancel_reason'],
            'order_created_at' => $order['created_at'],
            'order_updated_at' => $order['updated_at'],
            'order_cancelled_at' => $order['cancelled_at'],
            'order_closed_at' => $order['closed_at'],
            'order_processed_at' => $order['processed_at']
        ];
        Order::updateOrCreate([
            'store_id' => $store_id,
            'order_id' => $order_id
        ], $orderData);
        if (isset($order['line_items']) && count($order['line_items']) > 0) {
            foreach ($order['line_items'] as $line_item) {
                $orderLineItemData = [
                    'store_id' => $store_id,
                    'order_id' => $order_id,
                    'lineitem_id' => strval($line_item['id']),
                    'shopify_product_id' => strval($line_item['product_id']),
                    'variant_id' => strval($line_item['variant_id']),
                    'name' => $line_item['name'],
                    'quantity' => $line_item['quantity'],
                    'sku' => $line_item['sku'],
                    'vendor' => $line_item['vendor'],
                    'fulfillment_service' => $line_item['fulfillment_service'],
                    'requires_shipping' => $line_item['requires_shipping'],
                    'taxable' => $line_item['taxable'],
                    'grams' => $line_item['grams'],
                    'price' => $line_item['price'],
                    'total_discount' => $line_item['total_discount'],
                    'fulfillment_status' => $line_item['fulfillment_status']
                ];
                OrderItem::updateOrCreate([
                    'store_id' => $store_id,
                    'order_id' => $order_id,
                    'variant_id' => $orderLineItemData['variant_id']
                ], $orderLineItemData);
            }
        }
        if (isset($order['customer']) && count($order['customer']) > 0) {
            $customer = $order['customer'];
            $orderCustomerData = [
                'store_id' => $store_id,
                'order_id' => $order_id,
                'customer_id' => strval($customer['id']),
                'first_name' => $customer['first_name'],
                'last_name' => $customer['last_name'],
                'email' => $customer['email'],
                'phone' => $customer['phone'],
                'tags' => $customer['tags'],
                'orders_count' => $customer['orders_count'],
                'state' => $customer['state'],
                'total_spent' => $customer['total_spent'],
                'company' => $customer['default_address']['company'],
                'address1' => $customer['default_address']['address1'],
                'address2' => $customer['default_address']['address2'],
                'city' => $customer['default_address']['city'],
                'province' => $customer['default_address']['province'],
                'country' => $customer['default_address']['country'],
                'zip' => $customer['default_address']['zip']
            ];
            OrderCustomer::updateOrCreate([
                'store_id' => $store_id,
                'order_id' => $order_id,
                'customer_id' => $orderCustomerData['customer_id']
            ], $orderCustomerData);
        }
        if (isset($order['billing_address']) && count($order['billing_address']) > 0) {
            $orderBillingAddress = $order['billing_address'];
            $billingAddressData = [
                'store_id' => $store_id,
                'order_id' => $order_id,
                'billing_name' => $orderBillingAddress['name'],
                'billing_phone' => $orderBillingAddress['phone'],
                'billing_company' => $orderBillingAddress['company'],
                'billing_address1' => $orderBillingAddress['address1'],
                'billing_address2' => $orderBillingAddress['address2'],
                'billing_city' => $orderBillingAddress['city'],
                'billing_province' => $orderBillingAddress['province'],
                'billing_province_code' => $orderBillingAddress['province_code'],
                'billing_country' => $orderBillingAddress['country'],
                'billing_country_code' => $orderBillingAddress['country_code'],
                'billing_zip' => $orderBillingAddress['zip'],
                'billing_latitude' => $orderBillingAddress['latitude'],
                'billing_longitude' => $orderBillingAddress['longitude']
            ];
            OrderBillingAddress::updateOrCreate([
                'store_id' => $store_id,
                'order_id' => $order_id
            ], $billingAddressData);
        }
        if (isset($order['shipping_address']) && count($order['shipping_address']) > 0) {
            $orderShippingAddress = $order['shipping_address'];
            $shippingAddressData = [
                'store_id' => $store_id,
                'order_id' => $order_id,
                'name' => $orderShippingAddress['name'],
                'phone' => $orderShippingAddress['phone'],
                'company' => $orderShippingAddress['company'],
                'address1' => $orderShippingAddress['address1'],
                'address2' => $orderShippingAddress['address2'],
                'city' => $orderShippingAddress['city'],
                'province' => $orderShippingAddress['province'],
                'province_code' => $orderShippingAddress['province_code'],
                'country' => $orderShippingAddress['country'],
                'country_code' => $orderShippingAddress['country_code'],
                'zip' => $orderShippingAddress['zip'],
                'latitude' => $orderShippingAddress['latitude'],
                'longitude' => $orderShippingAddress['longitude']
            ];
            OrderShippingAddress::updateOrCreate([
                'store_id' => $store_id,
                'order_id' => $order_id
            ], $shippingAddressData);
        }
    }


    /**
     * @param $store
     */
    public static function sync($store)
    {
        $last_page = false;
        $params = array('limit' => 250);
        while (!$last_page) {
            $end_point = "/admin/api/" . env('PUBLIC_APP_API_VERSION') . "/orders.json";
            $request = Shopify::call($store->token, $store->domain, $end_point, $params, 'GET');
            $header = AppHelper::getShopifyNextPageArray($request['headers']);
            $response = json_decode($request['response'], JSON_PRETTY_PRINT);
            if (isset($response['orders']) && count($response['orders']) > 0) {
                foreach ($response['orders'] as $order) {
                    self::manageOrder($order, $store);
                }
            }
            if (isset($header['next_page'])) {
                $params['page_info'] = $header['next_page'];
            }
            $last_page = $header['last_page'];
        }
    }
}
