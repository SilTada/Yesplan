<?php

namespace Yesplan\Endpoints;

class Events {
    
    public static function getList($client, $searchquery = null) {
        $request = $client->newRequest('GET', 'events', null, null, $searchquery);
        $result = $request->run();
        return $result;
    }
    
    public static function get($client, $id) {
        $request = $client->newRequest('GET', "event/$id");
        $result = $request->run();
        return $result;
    }
    
    public static function getSchedule($client, $id) {
        $request = $client->newRequest('GET', "event/$id/schedule");
        $result = $request->run();
        return $result;
    }
    
    public static function getAttachments($client, $id) {
        $request = $client->newRequest('GET', "event/$id/attachments");
        $result = $request->run();
        return $result;
    }
    
    public static function getCustomdata($client, $id, $query) {
        $request = $client->newRequest('GET', "event/$id/customdata", null, $query);
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
                    if(!empty($subitem->value))
                        $data->{$subitem->keyword} = $subitem->value;
                }
            } else {
                if(!empty($item->value))
                    $data->{$item->keyword} = $item->value;
            }
        }
        return $data;
    }
    
    public static function getResourcebookings($client, $id) {
        $request = $client->newRequest('GET', "event/$id/resourcebookings");
        $result = $request->run();
        return $result;
    }
    
    public static function filterResourcesbookings($resources, $type = "human") {
        $i = 0;
        $data = array();
        foreach($resources as $resource) {
            if(property_exists($resource, 'children')) {
                foreach($resource->children as $item) {
                    if($item->resource->resourcetype == $type) {
                        $data[$i] = new \stdClass();
                        $data[$i]->name = $item->resource->name;
                        if($item->role)
                            $data[$i]->role = $item->role;
                        $i++;
                    }
                }
            } else {
                if($resource->resource->resourcetype == $type) {
                    $data[$i] = new \stdClass();
                    $data[$i]->name = $resource->resource->name;
                    if($item->role)
                        $data[$i]->role = $resource->role;
                    $i++;
                }
            }
        }
        return $data;
    }
    
    public static function putCustomdata($client, $id, $data) {
        $request = $client->newRequest('PUT', 'event/'.$id.'/customdata', $data);
        $result = $request->run();
        return $result;
    }



}