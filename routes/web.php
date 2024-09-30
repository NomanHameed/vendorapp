<?php

use Illuminate\Support\Facades\Route;
use App\Lib\AuthRedirection;
use App\Lib\EnsureBilling;
use App\Http\Livewire\Auth\ForgotPassword;
use App\Http\Livewire\Auth\ResetPassword;
use App\Http\Livewire\Auth\SignUp;
use App\Http\Livewire\Auth\Login;
use App\Http\Livewire\Dashboard;
use App\Http\Livewire\Billing;
use App\Http\Livewire\Profile;
use App\Http\Livewire\Tables;
use App\Http\Livewire\StaticSignIn;
use App\Http\Livewire\StaticSignUp;
use App\Http\Livewire\Rtl;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Shopify\Auth\OAuth;
use Shopify\Auth\Session as AuthSession;
use Shopify\Clients\HttpHeaders;
use Shopify\Clients\Rest;
use Shopify\Context;
use Shopify\Exception\InvalidWebhookException;
use Shopify\Utils;
use Shopify\Webhooks\Registry;
use Shopify\Webhooks\Topics;

use App\Http\Livewire\LaravelExamples\UserProfile;
use App\Http\Livewire\LaravelExamples\UserManagement;
use App\Http\Livewire\Products;
use App\Models\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::fallback(function (Request $request) {
    if (Context::$IS_EMBEDDED_APP && $request->query("embedded", false) === "1") {
        if (env('APP_ENV') === 'production') {
            return file_get_contents(public_path('index.html'));
        } else {
            return file_get_contents(base_path('frontend/index.html'));
        }
    } else {
        return redirect(Utils::getEmbeddedAppUrl($request->query("host", null)) . "/" . $request->path());
    }
})->middleware('shopify.installed');

Route::get('/api/auth', function (Request $request) {

    $shop = Utils::sanitizeShopDomain($request->query('shop'));
    dd($shop);
    // Delete any previously created OAuth sessions that were not completed (don't have an access token)
    $session = Session::where('shop', $shop)->where('access_token', null)->first();
    if($session){
        $session->delete();
    }

    return AuthRedirection::redirect($request);
});

Route::get('/api/auth/callback', function (Request $request) {

    try{
            $session = OAuth::callback(
                $request->cookie(),
                $request->query(),
                ['App\Lib\CookieHandler', 'saveShopifyCookie'],
            );

            $host = $request->query('host');
            $shop = Utils::sanitizeShopDomain($request->query('shop'));

            $response = Registry::register('/api/webhooks', Topics::APP_UNINSTALLED, $shop, $session->getAccessToken());

            if ($response->isSuccess()) {
                Log::debug("Registered APP_UNINSTALLED webhook for shop $shop");
            } else {
                Log::error(
                    "Failed to register APP_UNINSTALLED webhook for shop $shop with response body: " .
                        print_r($response->getBody(), true)
                );
            }


            $redirectUrl = Utils::getEmbeddedAppUrl($host);
            if (Config::get('shopify.billing.required')) {
                list($hasPayment, $confirmationUrl) = EnsureBilling::check($session, Config::get('shopify.billing'));

                if (!$hasPayment) {
                    $redirectUrl = $confirmationUrl;
                }
            }

            return redirect($redirectUrl);

    } catch (Exception $e) {
        Log::warning('Failed to authenticate: ' . $e->getMessage());

        return redirect('/api/auth?shop=' . $request->query('shop'));
    }
});

Route::get('/', function() {
    return redirect('/login');
});

Route::get('/products', Products::class)->name('products');
Route::get('/sign-up', SignUp::class)->name('sign-up');
Route::get('/login', Login::class)->name('login');

Route::get('/login/forgot-password', ForgotPassword::class)->name('forgot-password');

Route::get('/reset-password/{id}',ResetPassword::class)->name('reset-password')->middleware('signed');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('/billing', Billing::class)->name('billing');
    Route::get('/profile', Profile::class)->name('profile');
    Route::get('/tables', Tables::class)->name('tables');
    Route::get('/static-sign-in', StaticSignIn::class)->name('sign-in');
    Route::get('/static-sign-up', StaticSignUp::class)->name('static-sign-up');
    Route::get('/rtl', Rtl::class)->name('rtl');
    Route::get('/laravel-user-profile', UserProfile::class)->name('user-profile');
    Route::get('/laravel-user-management', UserManagement::class)->name('user-management');
});

