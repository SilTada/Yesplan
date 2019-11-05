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
    
    public static function getCustomdata($client, $id, $query = null) {
        $request = $client->newRequest('GET', "location/$id/customdata", $query);
        $result = $request->run();
        if(empty($query)) {
            $data = $result->groups;
        } else {
            $data = $result->items;
        }
        return $data;
    }
    
    public static function customdataByKey($custom_data) {
        $data = new \stdClass();
        foreach($custom_data as $item) {
            if(property_exists($item, 'children')) {
                foreach($item->children as $subitem) {
                    $data->{$subitem->keyword} = $subitem->value;
                }
            } else {
                $data->{$item->keyword} = $item->value;
            }
        }
        return $data;
    }
    
}
