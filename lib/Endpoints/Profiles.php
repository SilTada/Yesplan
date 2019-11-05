<?php

namespace Yesplan\Endpoints;

class Profiles {
    
    public static function getList($client, $searchquery = null) {
        $request = $client->newRequest('GET', 'profiles', null, $searchquery);
        $result = $request->run();
        return $result;
    }
    
    public static function get($client, $id) {
        $request = $client->newRequest('GET', "profile/$id");
        $result = $request->run();
        return $result;
    }
    
}