<?php


namespace App;


use App\Models\CollectionField;
use App\Models\GApi;
use App\Models\OrderField;
use App\Models\ProductField;
use App\Models\Sheet;
use App\Models\Store;
use App\Models\StoreActiveField;
use App\Models\StoreSheet;
use App\Models\StoreSheetActiveResource;
use Illuminate\Database\Eloquent\Collection;

class AppHelper
{
    /**
     * Get the next page Array
     * @param $header
     * @return array
     */
    public static function getShopifyNextPageArray($header): array
    {
        $response = array();
        if (isset($header['link'])) {
            $links = explode(',', $header['link']);
            foreach ($links as $link) {
                if (strpos($link, 'rel="next"')) {
                    preg_match('~<(.*?)>~', $link, $next);
                    $url_components = parse_url($next[1]);
                    parse_str($url_components['query'], $params);
                    $response['next_page'] = $params['page_info'];
                    $response['last_page'] = false;
                } else {
                    $response['last_page'] = true;
                }
            }
        } else {
            $response['last_page'] = true;
        }
        return $response;
    }

    /**
     * @param $array
     * @param $keyword
     * @return array
     */
    public static function array_partial_search($array, $keyword)
    {
        $found = [];
        foreach ($array as $string) {
            if (strpos($string, $keyword) !== false) {
                $found[] = trim(str_replace($keyword, '', $string));
            }
        }
        return $found;
    }


    /**
     * @param $request
     * @return array
     */
    public static function getAppRequests($request): array
    {
        $requestArray = array();
        $requestArray['hmac'] = $request->get('hmac', null);
        $requestArray['locale'] = $request->get('locale', null);
        $requestArray['new_design_language'] = $request->get('new_design_language', null);
        $requestArray['session'] = $request->get('session', null);
        $requestArray['shop'] = $request->get('shop', 'scarlet-test-store.myshopify.com');
        $requestArray['timestamp'] = $request->get('timestamp', null);
        $domain = $request->get('shop', 'scarlet-test-store.myshopify.com');
        $store = Store::whereDomain($domain)->first();
        $requestArray['store_id'] = $store->store_id;
        $requestArray['domain'] = $store->domain;
        $requestArray['token'] = $store->token;
        $requestArray['store'] = $store;
        // $request->request->set('store', $store);
        // $request->request->set('store_id',  $store->store_id);
        // $request->request->set('domain',  $store->domain);
        // $request->request->set('token',  $store->token);
        return $requestArray;
    }

    /**
     * @param $storeId
     * @return
     */
    public static function getToken($storeId)
    {
        return StoreSheet::where('store_id', $storeId)
            ->whereNull('parent_id')
            ->whereStatus('active')
            ->value('token');
    }

}
