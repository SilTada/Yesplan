<?php

namespace Yesplan\Endpoints;

class Locations {
    
    public static function getList($client, $searchquery = null) {
        $request = $client->newRequest('GET', 'locations', null, $searchquery);
        $result = $request->run();
        return $result;
    }
    
    public static function get($client, $id) {
        $request = $client->newRequest('GET', "location/$id");
        $result = $request->run();
        return $result;
    }
    
    public static function getCustomdata($client, $id, $keywords) {
        $query = "keywords=";
        if(is_string($keywords)) {
            if(substr($keywords, 0, 9) === $query) {
                $query = $keywords;
            } else {
                $query .= $keywords;
            }
        } else if(is_array($keywords)) {
            $query .= implode(',', $keywords);
        }
        $request = $client->newRequest('GET', "location/$id/customdata", null, $query);
        $result = $request->run();
        if(empty($keywords)) {
            if(property_exists($result, 'groups') && !empty($result->groups))
                $data = $result->groups;
        } else {
            if(property_exists($result, 'items') && !empty($result->items))
                $data = $result->items;
        }
        if(isset($data)) {
            return $data;
        } else {
            return $data = (object) [
                'error' => true,
                'message' => 'No data.'
            ];
        }
    }
    
}
