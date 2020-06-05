<?php

namespace Yesplan\Endpoints;

class Groups {
    
    //---- GET REQUESTS ----//
    
    public static function getList($client, $searchquery = null) {
        $request = $client->newRequest('GET', 'groups', null, null, $searchquery);
        $result = $request->run();
        return $result;
    }
    
    public static function get($client, $id) {
        $request = $client->newRequest('GET', "group/$id");
        $result = $request->run();
        return $result;
    }
    
    public static function getSchedule($client, $id) {
        $request = $client->newRequest('GET', "group/$id/schedule");
        $result = $request->run();
        return $result;
    }
    
    public static function getAttachments($client, $id) {
        $request = $client->newRequest('GET', "group/$id/attachments");
        $result = $request->run();
        return $result;
    }
    
    public static function getCustomdata($client, $id, $keywords) {
        $endpoint = 'group/'.$id.'/customdata';
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
        $request = $client->newRequest('GET', $endpoint, null, $query);
        $result = $request->run();
        if(property_exists($result, 'items') && !empty($result->items)) 
            $data = $result->items;
            $data = \Yesplan\Filter::customdataByKey($result->items);
        if(empty($keywords))
            if(property_exists($result, 'groups') && !empty($result->groups))
                $data = $result->groups;
        
        if(isset($data)) {
            return $data;
        } else {
            return $data = (object) [
                'error' => true,
                'message' => 'No data.'
            ];
        }
    }
    
    public static function getCustomdataValuesOnly($client, $id) {
        $endpoint = 'group/'.$id.'/customdata?valuesonly';
        $request = $client->newRequest('GET', $endpoint, null, null);
        $result = $request->run();
        if(property_exists($result, 'items') && !empty($result->items)) 
            $data = $result->items;
        
        if(isset($data)) {
            return $data;
        } else {
            return $data = (object) [
                'error' => true,
                'message' => 'No data.'
            ];
        }
    }
    
    public static function getResourcebookings($client, $id) {
        $request = $client->newRequest('GET', "group/$id/resourcebookings");
        $result = $request->run();
        return $result;
    }
    
    
    //---- PUT REQUESTS ----//
    
    public static function putCustomdata($client, $id, $data) {
        $request = $client->newRequest('PUT', 'group/'.$id.'/customdata', $data);
        $result = $request->run();
        return $result;
    }



}
