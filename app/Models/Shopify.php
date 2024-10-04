<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Shopify extends Model
{

    public static $headers; 
    /**
     * @param $token
     * @param $shop
     * @param $api_endpoint
     * @param array $query
     * @param string $method
     * @param array $request_headers
     * @return array|string
     */
    public static function call($token, $shop, $endpoint, $query = array(), $method = 'GET', $request_headers = array())
    {
        $url = "https://" . $shop . '/admin/api/' . env('PUBLIC_APP_API_VERSION') . '/'.$endpoint.'.json';
        
        if (!is_null($query) && in_array($method, array('GET', 'DELETE'))) 
        $url = $url . "?" . http_build_query($query);
        
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HEADER, TRUE);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, false);
        curl_setopt($curl, CURLOPT_MAXREDIRS, 3);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_USERAGENT, 'My New Shopify App v.1');
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 500);
        curl_setopt($curl, CURLOPT_TIMEOUT, 500);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
        $request_headers[] = "";
        if (in_array($method, array('POST','PUT'))){
            $query = json_encode($query);
            $request_headers = in_array($method, array('POST','PUT')) ? array("Content-Type: application/json; charset=utf-8", 'Expect:') : array();
        }else{
            $query = array();
        }
        
        if (!is_null($token)) $request_headers[] = "X-Shopify-Access-Token: " . $token;
        curl_setopt($curl, CURLOPT_HTTPHEADER, $request_headers);
        if ($method != 'GET' && in_array($method, array('POST', 'PUT'))) {
            if (is_array($query)) $query = http_build_query($query);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $query);
        }
        $response = curl_exec($curl);
        $error_number = curl_errno($curl);
        $error_message = curl_error($curl);
        curl_close($curl);
        if ($error_number) {
            return $error_message;
        } else {
            $response = preg_split("/\r\n\r\n|\n\n|\r\r/", $response, 2);
            $headers = array();
            $header_data = explode("\n", $response[0]);
            $headers['status'] = $header_data[0];
            array_shift($header_data);
            foreach ($header_data as $part) {
                $h = explode(":", $part, 2);
                $headers[trim($h[0])] = trim($h[1]);
            }
            self::$headers = $headers;
            // return array('headers' => $headers, 'response' => $response[1]);
            return  json_decode($response[1], true);
        }
    }

}
