<?php

namespace Yesplan\Endpoints;

use Exception;

abstract class Endpoint
{

    public readonly object $client;
    public string $endpoint;
    public string $url;

    public function __construct(object $client, string $searchquery = "", string $query = "") 
    {
        $this->client = $client;
        $this->endpoint = strtolower(str_replace(__NAMESPACE__ . '\\', '', get_class($this)));
    }

    private function generateUrl(string $id = null, string $searchquery = null, string $query = null) 
    {
        if(isset($this->url)) {
            $url = $this->url;
        } else {
            $url = $this->client->server . '/api/' . $this->endpoint;
        }
        if($id) 
        {
            if (true)
            {
                $url .= "/$id";
            }
            else 
            {
                throw new Exception("Invallid ID given.");
            }
        }
        if($searchquery)
            $url .= '/'.urlencode($searchquery);
        $glue = '?';
        if(parse_url($url, PHP_URL_QUERY))
            $glue = '&';
        if($query) {
            $url .= $glue.$query;
            $glue = '&';
        }
        $url .= $glue.'api_key='.$this->client->api_key;
        
        return $url;    
    }

    public function all()
    {
        $this->endpoint .= 's';
        return $this->client->request($this->generateUrl());
    }

    public function find(string $searchquery)
    {
        $this->endpoint .= 's';
        return $this->client->request($this->generateUrl(null, $searchquery));
    }

    public function findByID(string $id)
    {
        return $this->client->request($this->generateUrl($id));
    }

}