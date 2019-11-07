<?php

namespace Yesplan;

class Filter {
    
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
    
    public static function resourcebookingsByType($resources, $type = "human") {
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
    
}