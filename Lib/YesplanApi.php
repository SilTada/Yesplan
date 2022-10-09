<?php

namespace Yesplan;

use Yesplan\Endpoints\Event;

class YesplanApi 
{

    public readonly string $clientname;

    public readonly string $server;

    public readonly string $api_key;

    public function __construct($clientname, $api_key)
    {
        $this->clientname = trim($clientname);
        $this->server = "https://$clientname.yesplan.be";
        $this->api_key = $api_key;

        $this->event = new Event($this);
    }

    public function request(string $url, string $method = "GET", array $data = null, string $notify_at = null)
    {
        if($method == 'GET') {
            $ch = curl_init($url);
            curl_setopt_array(
                $ch, 
                array(
                    CURLOPT_RETURNTRANSFER => TRUE
                )
            );
        } else if($method == 'POST') {
            $ch = curl_init($url);
            curl_setopt_array(
                $ch, 
                array(
                    CURLOPT_POST => TRUE,
                    CURLOPT_RETURNTRANSFER => TRUE,
                    CURLOPT_HTTPHEADER => array(
                        'Content-Type: application/json',
                        'X-Notify-At: '.$notify_at,
                    ),
                    CURLOPT_POSTFIELDS => json_encode($data)
                )
            );
        } else if($method == 'PUT') {
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
                    CURLOPT_POSTFIELDS => json_encode($data)
                )
            );
        }

        $response = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if($response === FALSE)
        {
            $response_data = (object)
            [
                'error' => true,
                'url' => $url,
                'message' => curl_error($ch)
            ];
        } else {
            $response_data = json_decode($response);
            if($httpcode == 401)
            {
                $response_data = (object)
                [
                    'error' => true,
                    'url' => $url,
                    'response_code' => $httpcode,
                    'message' => 'Unauthorized'
                ];
            }
            if($httpcode == 204) 
            {
                $response_data = (object)
                [
                    'error' => true,
                    'url' => $url,
                    'response_code' => $httpcode,
                    'message' => 'No Content'
                ];
            }
        }
        return $response_data; 
    }
    

}