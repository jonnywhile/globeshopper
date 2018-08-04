<?php

if (! function_exists('domains_to_array')) {
    /**
     * Convert domain objects in array to arrays
     *
     */
    function domains_to_array($collection)
    {
        $result = $collection->map(function($item) {
            return $item->toArray();
        });

        return $result;
    }
}