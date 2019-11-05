<?php

namespace Yesplan;

class Client {
    
    public $server;
    
    public $api_key;
    
    public function __construct($clientname, $api_key, $showUrl = false) {
        $this->server = "https://$clientname.yesplan.be";
        $this->api_key = $api_key;
        $this->showUrl = $showUrl;        
    }
    
    public function newRequest($method, $endpoint, $post_data = null, $query = null, $searchquery = null, $notify_at = null) {
        return new Request($this, $method, $endpoint, $post_data, $query, $searchquery, $notify_at, $url = null);
    }
    
    public function newRequestUrl($method, $url) {
        return new Request($this, $method, null, null, null, null, null, $url);
    }
}