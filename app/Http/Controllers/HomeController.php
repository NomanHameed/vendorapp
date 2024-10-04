<?php

namespace App\Http\Controllers;

// use App\AppHelper;
use App\Models\Shopify;
use App\Models\Store;
use Illuminate\Contracts\Auth\Factory;
use Illuminate\Contracts\Console\Application;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
// use App\Http\Controllers\FashionBizController;
use App\Jobs\ReadProducts;

class HomeController extends Controller
{
    /**
     * @param Request $request
     * @return Application|Factory|View|RedirectResponse
     */
    public function index(Request $request)
    {
        // $request->session()->pull('plan', 'free');
        // dd($request->all());
//        $domain = $request->get('shop', 'scarlet-test-store.myshopify.com');
        $domain = $request->get('shop', 'fillinxsolutions.myshopify.com');
        $hmac = $request->get('hmac', null);
        $timeStamp = $request->get('timestamp', null);
        // dd($domain);
        $storeQuery = Store::whereDomain($domain);
        if ($storeQuery->exists()) {
            $token = $storeQuery->value('token');
            $hooks = Shopify::call($token, $domain, '/admin/api/' . env('PUBLIC_APP_API_VERSION') . '/webhooks.json', array("topic" => 'app/uninstalled'), 'GET');
            if (isset($hooks['errors']) && $hooks['errors'] == '[API] Invalid API key or access token (unrecognized login or wrong password)') {
                return redirect()->route('install', [
                    'hmac' => $hmac,
                    'shop' => $domain,
                    'timestamp', $timeStamp
                ]);
            } else {
                if ($request->has('session')) {
                    return $this->manageAppHomePage($request);
                } else {
                    $return_url = 'https://' . $domain . "/admin/apps/" . env('PUBLIC_APP_NAME');
                    header("Location: " . $return_url);
                    die();
                }
            }
        } else {
            return redirect()->route('install', [
                'hmac' => $hmac,
                'shop' => $domain,
                'timestamp', $timeStamp
            ]);
        }

    }

    /**
     * @param Request $request
     */

    public function install(Request $request)
    {
//        $storeName = $request->get('shop', 'scarlet-test-store.myshopify.com');
        $storeName = $request->get('shop', 'fillinxsolutions.myshopify.com');
        $hMac = $request->get('hmac', null);

        Store::updateOrCreate([
            'domain' => $storeName
        ], [
            'domain' => $storeName,
            'hmac' => $hMac
        ]);

        $install_url = "https://" . $storeName . "/admin/oauth/authorize?client_id=" . env('PUBLIC_APP_API_KEY') . "&scope=" . trim(env('PUBLIC_APP_SCOPES')) . "&redirect_uri=" . urlencode(env('PUBLIC_APP_URL').'token');
        header("Location: " . $install_url);
        dd($install_url);
        die();
    }

    public function token(Request $request)
    {
        $params = $_GET;
        $hmac = $_GET['hmac'];
        $params = array_diff_key($params, array('hmac' => ''));
        ksort($params);
        $computed_hmac = hash_hmac('sha256', http_build_query($params), env('PUBLIC_APP_API_SECRET'));
        if (hash_equals($hmac, $computed_hmac)) {
            $query = array(
                "client_id" => env('PUBLIC_APP_API_KEY'),
                "client_secret" => env('PUBLIC_APP_API_SECRET'),
                "code" => $params['code']
            );
            $access_token_url = "https://" . $params['shop'] . "/admin/oauth/access_token";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_URL, $access_token_url);
            curl_setopt($ch, CURLOPT_POST, count($query));
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($query));
            $result = curl_exec($ch);
            curl_close($ch);


            $result = json_decode($result, true);

            $token = $result['access_token'];
            $domain = $request->get('shop', 'scarlet-test-store.myshopify.com');

            Store::sync($token, $domain);
            $store = Store::whereDomain($domain)->first();
            $store->token = $token;

            if( !empty($token) ){
                ReadProducts::dispatch($request->query('shop'));
            }

            if ($store->save()) {
                Store::manageWebHooks($store);

                $return_url = 'https://' . $domain . "/admin/apps/" . env('PUBLIC_APP_NAME');
                header("Location: " . $return_url);
                die();
            }
        } else {
            die('This request is NOT from Shopify!');
        }
    }

    /**
     * @param object $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|View
     */
    public function manageAppHomePage(object $request)
    {
        // dd($request);
        $data = ['shop' => $request['shop']];

        // $style = new FashionBizController();
        // return $style->index($request);
        // $request = AppHelper::getAppRequests($request);
        // $store = Store::whereStoreId($request['store_id'])->first();
        // return view('dashboard', $data);
        return redirect()->route('store.settings', $data);
    }

    public function gdprWebhook(Request $request){
        # The Shopify app's API secret key, viewable from the Partner Dashboard. In a production environment, set the API secret key as an environment variable to prevent exposing it in code.


        $headers = $request->header();
        $headers['data'] = json_decode(file_get_contents('php://input'), true);

        $hmac_header = $request->header('HTTP_X_SHOPIFY_HMAC_SHA256');
        // $domain = $request->header('X-Shopify-Shop-Domain');

        if(empty($hmac_header)) return response(['authorized'=>false], 401);

        $data = file_get_contents('php://input');
        $calculated_hmac = base64_encode(hash_hmac('sha256', $data, env('PUBLIC_APP_API_KEY'), true));
        $verified = hash_equals($hmac_header, $calculated_hmac);

        // dd([$hmac_header, $calculated_hmac, $verified]);

        // error_log('Webhook verified: '.var_export($verified, true)); // Check error.log to see the result
        if ($verified) {
            echo '200 OK';
        } else {
            // http_response_code(401);
            return response(['authorized'=>false], 401);
        }
    }
}
