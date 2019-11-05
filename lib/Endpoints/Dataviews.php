<?php

namespace Yesplan\Endpoints;

class Dataviews {
    
    public static function compute($client, $id, $params, $notify_at) {
        $request = $client->newRequest('POST', 'dataviewresult/'.$id.'/json', $params, null, null, $notify_at);
        $result = $request->run();
        return $result;
    }
    
    public static function status($client, $id, $result_id) {
        $request = $client->newRequest('GET', 'dataviewresult/'.$id.'/json/'.$result_id.'/status');
        $result = $request->run();
        return $result;
    }
    
    public static function get($client, $id, $result_id) {
        $request = $client->newRequest('GET', 'dataviewresult/'.$id.'/json/'.$result_id);
        $result = $request->run();
        return $result;
    }
    
}