<?php

namespace App\Classes;

/**
 * --------------------------------------------------------------------------
 * S&S Activewear API
 *
 * --------------------------------------------------------------------------
 */

class TrackPOD
{

    private $__domain = 'https://api.track-pod.com/';
    private $__Token  = 'a44c1644-fe65-4d18-86ca-abc5df68dc7c';

    private $__task = '';
    private $__method = 'GET';
    private $__params = array();
    public  $next = null;
    private $__waitingTaskInfo = array();
    private $__ch = null;
    private $__curlExpireTime = 10;

    /**
     * @desc Construct
     * @access public
     */
    public function __construct($settings = '')
    {
        $this->__ch = curl_init();
    }

    public function hasNextPage()
    {
        return $this->next ? true : false;
    }


    /**
     * @desc product list or single product
     * @access public
     * @var $productIDs - comma separated list of product identifiers
     */
    public function postOrder($request)
    {
        $this->__task = "Order";
        $this->__method = 'POST';
        $this->__params = $request;
        
        $result = $this->__doRequest();

        return $result;
    }

    /**
     * @desc set params
     * @access public
     */
    public function setParams(array $params)
    {
        if (!empty($params)) {
            $this->__params = $params;
        }
    }

    /**
     * @desc send api request
     * @access private
     */
    private function __doRequest()
    {

        $apiUrl = $this->__domain . $this->__task;

        if ($this->__method == 'GET' && !empty($this->__params)) {
            $apiUrl .= '?' . http_build_query($this->__params);
        }

        $headers = [
            "X-API-KEY: " . $this->__Token,
            'Content-Type: application/json'
        ];

        curl_setopt($this->__ch, CURLOPT_URL, $apiUrl);
        // curl_setopt($this->__ch, CURLOPT_HEADER, 0);
        // curl_setopt($this->__ch, CURLOPT_USERAGENT, $_SERVER ['HTTP_USER_AGENT']);
        curl_setopt($this->__ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($this->__ch, CURLOPT_RETURNTRANSFER, 1);
        // curl_setopt($this->__ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($this->__ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($this->__ch, CURLOPT_CUSTOMREQUEST, $this->__method);

        if ($this->__method == 'POST') {
            curl_setopt($this->__ch, CURLOPT_POSTFIELDS, json_encode($this->__params));
        }

        if ($this->__curlExpireTime > 0) {
            curl_setopt($this->__ch, CURLOPT_TIMEOUT, $this->__curlExpireTime);
        }

        $result = curl_exec($this->__ch);
        $result = json_decode($result);

        if (!empty($result) && is_object($result)) $this->next = property_exists($result, 'next') ? $result->next : $this->next;

        return $result;
    }
}
