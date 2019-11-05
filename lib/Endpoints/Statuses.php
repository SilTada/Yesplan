<?php

namespace Yesplan\Endpoints;

class Statuses {
    
    public static function getList($client, $searchquery = null) {
        $request = $client->newRequest('GET', 'statuses', null, $searchquery);
        $result = $request->run();
        return $result;
    }
    
    public static function get($client, $id) {
        $request = $client->newRequest('GET', "status/$id");
        $result = $request->run();
        return $result;
    }
    
}