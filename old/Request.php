<?php

namespace Yesplan;

class Request {
    
    private $client;
    private $method;
    private $endpoint;
    private $post_data;
    private $query;
    private $searchquery;
    
    public function __construct($client, $method, $endpoint, $post_data = null, $query = null, $searchquery = null, $notify_at = null, $url = null) {
        $this->client = $client;
        $this->method = $method;
        $this->endpoint = $endpoint;
        $this->post_data = $post_data;
        $this->query = $query;
        $this->searchquery = $searchquery;
        $this->notify_at = $notify_at;
        $this->url = $url;
    }
    
    public function run() {
        $url = $this->generateUrl();
        if($this->client->showUrl)
            trigger_error("Request url: $url");
        
        if($this->method == 'GET') {
            $ch = curl_init($url);
            curl_setopt_array(
                $ch, 
                array(
                    CURLOPT_RETURNTRANSFER => TRUE
                )
            );
        } else if($this->method == 'POST') {
            $ch = curl_init($url);
            curl_setopt_array(
                $ch, 
                array(
                    CURLOPT_POST => TRUE,
                    CURLOPT_RETURNTRANSFER => TRUE,
                    CURLOPT_HTTPHEADER => array(
                        'Content-Type: application/json',
                        'X-Notify-At: '.$this->notify_at,
                    ),
                    CURLOPT_POSTFIELDS => json_encode($this->post_data)
                )
            );
        } else if($this->method == 'PUT') {
            $ch = curl_init($url);
            curl_setopt_array(
                $ch, 
                array(
                    CURLOPT_RETURNTRANSFER => TRUE,
                    CURLOPT_CUSTOMREQUEST => "PUT",
                    CURLOPT_HEADER => TRUE,
                    CURLOPT_HTTPHEADER => array(
                        'Content-Type: application/json',
                    ),
                    CURLOPT_POSTFIELDS => json_encode($this->post_data)
                )
            );
        }
        $response = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if($response === FALSE){
            die(curl_error($ch));
        }
        $response_data = json_decode($response);
        if($httpcode == 401) {
            $response_data = (object)[
                'error' => true,
                'response_code' => 401,
                'message' => 'Unauthorized'
            ];
            //die("API error: 401 Unauthorized");
        }
        if($httpcode == 204) {
            $response_data = (object)[
                'error' => true,
                'response_code' => 204,
                'message' => 'No Content'
            ];
            //die("API error: 204 No Content");
        }
        return $response_data;       
        
    }
    
    private function generateUrl() {
        if($this->url) {
            $url = $this->url;
        } else {
            $url = $this->client->server . "/api/" . $this->endpoint;
        }
        if($this->searchquery)
            $url .= '/'.urlencode($this->searchquery);
        $glue = '?';
        if(parse_url($url, PHP_URL_QUERY))
            $glue = '&';
        if($this->query) {
            $url .= $glue.$this->query;
            $glue = '&';
        }
        $url .= $glue.'api_key='.$this->client->api_key;
        
        return $url;        
    }
    
}
