<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AppHelper;
use App\Models\StoreSettings;
use App\Classes\SSActivewear;
use App\Models\Shopify;
use App\Models\Store;

class StoreController extends Controller
{

    /**
     * Store Settings
     * @param Request $request
     * @return @view
     */
    public function Settings(Request $request)
    {
        $shop = $request->get('shop');
        $store = Store::where('domain', $shop)->first();
        $settings = $store->settings ?? ['store_id'=>$store->store_id];

        // dd($settings);
        return view('store.settings',  $settings);
    }

    /**
     * Store Update Settings
     * @param Request $request
     * @return array
     */
    public function updateSettings(Request $request): array
    {
        $store = Store::where('domain', 'scarletbrandingshop.myshopify.com')->first();

        $store_id = $store->store_id;
        // $store_id = $request->get('store_id');

        $storeSettings = [
            // 'api_key' => $request->get('api_key'),
            // 'account_number' => $request->get('account_number'),
            // 'new_product' => $request->get('new_product'),
            'marrgin_type' => $request->get('marrgin_type'),
            'price_margin' => $request->get('price_margin'),
            'import_cats' => $request->get('import_cats') ?? 0,
            'import_brands' => $request->get('import_brands') ?? 0,
        ];
        
        $settings = StoreSettings::updateOrCreate([
            'store_id' => $store_id
        ], $storeSettings);
        
        return ['success' => true, 'msg' => 'Updated successflly!'];
    }
    
}
