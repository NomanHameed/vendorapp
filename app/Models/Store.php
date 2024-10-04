<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Store extends Model
{
    protected $dates = [
        'created_at',
        'updated_at'
    ];
    protected $fillable = [
        'store_id',
        'email',
        'customer_email',
        'primary_location_id',
        'domain',
        'shop_domain',
        'primary_locale',

        'address1',
        'address2',
        'city',
        'country',
        'country_code',
        'province',
        'province_code',
        'zip',
        'latitude',
        'longitude',
        'currency',
        'enabled_presentment_currencies',
        'money_format',
        'store_name',
        'store_owner',
        'plan_display_name',
        'plan_name',
        'force_ssl',
        'token',
        'store_created_at',
        'store_updated_at',
    ];

    /**
     * @return HasMany
     */
    public function products()
    {
        return $this->hasMany(Product::class, 'store_id', 'store_id');
    }

    /**
     * @return hasOne
     */
    public function settings()
    {
        return $this->hasOne(StoreSettings::class, 'store_id', 'store_id');
    }

    /**
     * @return hasMany
     */
    public function payments()
    {
        return $this->hasMany(Payment::class, 'store_id', 'store_id');
    }

    /**
     * @return hasMany
     */
    public function activePayment()
    {
        return $this->hasMany(Payment::class, 'store_id', 'store_id')->where('status', 'active');
    }


    /**
     * @param $token
     * @param $domain
     */
    public static function sync($token, $domain)
    {
        
        $response = Shopify::call($token, $domain, "shop", null, 'GET');
        // dd($response);
        if (isset($response['shop']) && count($response['shop']) > 0) {
            $storeObject = $response['shop'];
            $store_id = strval(trim($storeObject['id']));
            Store::updateOrCreate([
                'domain' => $storeObject['myshopify_domain']
            ], [
                'domain' => $storeObject['myshopify_domain'],
                'shop_domain' => $storeObject['domain'],
                'email' => $storeObject['email'],
                'customer_email' => $storeObject['customer_email'],
                'store_id' => $store_id,
                'primary_location_id' => strval(trim($storeObject['primary_location_id'])),
                'primary_locale' => $storeObject['primary_locale'],
                'country' => $storeObject['country_name'],
                'country_code' => $storeObject['country_code'],
                'province' => $storeObject['province'],
                'province_code' => $storeObject['province_code'],
                'city' => $storeObject['city'],
                'address1' => $storeObject['address1'],
                'address2' => $storeObject['address2'],
                'zip' => $storeObject['zip'],
                'latitude' => $storeObject['latitude'],
                'longitude' => $storeObject['longitude'],
                'currency' => $storeObject['currency'],
                'enabled_presentment_currencies' => json_encode($storeObject['enabled_presentment_currencies']),
                'money_format' => $storeObject['money_format'],
                'store_name' => $storeObject['name'],
                'store_owner' => $storeObject['shop_owner'],
                'plan_display_name' => $storeObject['plan_display_name'],
                'plan_name' => $storeObject['plan_name'],
                // 'force_ssl' => $storeObject['force_ssl'],
                'store_created_at' => $storeObject['created_at'],
                'store_updated_at' => $storeObject['updated_at'],
            ]);
            // self::manageMetaFields($token, $domain, $store_id);
        }
    }

    /**
     * Store - MetaFields
     * @param $token
     * @param $domain
     * @param $store_id
     */
    public static function manageMetaFields($token, $domain, $store_id)
    {
        $meta_field_end_point = "/admin/api/" . env('PUBLIC_APP_API_VERSION') . "/metafields.json";
        $meta_field_response = Shopify::call($token, $domain, $meta_field_end_point, null, 'GET');
        $response = json_decode($meta_field_response['response'], JSON_PRETTY_PRINT);
        if (isset($response['metafields']) && count($response['metafields']) > 0) {
            foreach ($response['metafields'] as $metafield) {
                $meta_id = strval(trim($metafield['id']));
                $owner_id = strval(trim($metafield['owner_id']));
                Metafield::updateOrCreate([
                    'store_id' => $store_id,
                    'meta_id' => $meta_id,
                    'meta_owner_id' => $owner_id
                ], [
                    'store_id' => $store_id,
                    'meta_id' => $meta_id,
                    'meta_owner_id' => $owner_id,
                    'meta_owner_resource' => $metafield['owner_resource'],
                    "meta_namespace" => $metafield['namespace'],
                    'meta_key' => $metafield['key'],
                    'meta_value' => $metafield['value'],
                    'meta_value_type' => $metafield['value_type'],
                    'meta_description' => $metafield['description'],
                    'meta_created_at' => $metafield['created_at'],
                    'meta_updated_at' => $metafield['updated_at']
                ]);
            }
        }
    }

    /**
     * Manage - WebHooks
     * @param $store
     */

    public static function manageWebHooks($store)
    {
        WebHook::whereStoreId(strval($store->store_id))->delete();

        WebHook::createOrder($store);
        WebHook::updateOrder($store);
        WebHook::deleteOrder($store);
        WebHook::createCustomer($store);
        WebHook::deleteCustomer($store);
    }

}
