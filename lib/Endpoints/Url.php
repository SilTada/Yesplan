<?php

namespace Yesplan\Endpoints;

class Url {
    
    public static function get($client, $url) {
        $request = $client->newRequestUrl('GET', $url);
        $result = $request->run();
        return $result;
    }
    
}