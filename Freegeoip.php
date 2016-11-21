<?php

/* 
 * Access freegeoip.net from Yii.
 * @author David Webb <david@dpwlabs.com>
 * 
 * 
 */

namespace dpwlabs\freegeoip;

use Yii;
use yii\base\Component;

class Freegeoip extends Component
{
    public $config = ['format' => 'json'];
    
    public function init()
    {
    }
    
    public function getConfig() {
        return $this->config;
    }
	
	
	/**
     * Send a GET requst using cURL
     * @param string $url to request
     * @param array $options for cURL
     * @return string
     */
    private function curl_get($url, array $options = array()) {
        $defaults = [
            CURLOPT_POST => 0,
            CURLOPT_HEADER => 0,
            CURLOPT_URL => $url,
            CURLOPT_FRESH_CONNECT => 1,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_FORBID_REUSE => 1,
            CURLOPT_TIMEOUT => 4,
            CURLOPT_SSL_VERIFYPEER => 0,
        ];

        $ch = curl_init();
        curl_setopt_array($ch, ($options + $defaults));
        if (!$result = curl_exec($ch)) {
            return false;
            //trigger_error(curl_error($ch));
        }
        curl_close($ch);
        return $result;
    }

    public function getRemoteLocation() {
        $ip_addr = $_SERVER['REMOTE_ADDR'];
        $url = 'http://freegeoip.net/' . $this->config['format'] .'/' . $ip_addr;
        $result = $this->curl_get($url);
        return $result;
    }
}