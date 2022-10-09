<?php

class Yesplan 
{
    
    public $clientname;

    public $server;
    
    public $api_key;
    
    public function __construct($clientname, $api_key) 
    {
        $this->clientname = trim($clientname);
        $this->server = "https://$clientname.yesplan.be";
        $this->api_key = $api_key;
    }
    
}
