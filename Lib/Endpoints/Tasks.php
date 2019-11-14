<?php

namespace Yesplan\Endpoints;

class Tasks {
    
    public static function getList($client, $searchquery = null) {
        $request = $client->newRequest('GET', 'tasks', null, $searchquery);
        $result = $request->run();
        return $result;
    }
    
    public static function get($client, $id) {
        $request = $client->newRequest('GET', "tasks/$id");
        $result = $request->run();
        return $result;
    }
    
    
}
