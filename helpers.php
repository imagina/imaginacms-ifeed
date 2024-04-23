<?php

/**
 *  /feed/products?filter={"category":x}&take=x
 *  /feed/products?filter[category]=x&take=x
 */
if (!function_exists('ifeedGetParamsToItems')) {
    function ifeedGetParamsToItems($request,$itemType='Products')
    {

        //Limit
        $params['take'] = setting('ifeed::limit'.$itemType.'Rss');
        if($request->filled('take')) $params['take'] = $request->input('take');
        //Page
        if($request->filled('page')) $params['page'] = $request->input('page');

        //Filters
        if($request->filled('filter')){
            $filter = $request->input('filter');
            if(is_array($filter))
                $params['filter'] = $request->input('filter');
            else    
                $params['filter'] = json_decode($request->input('filter'));

        } 
        
        return $params;
    } 
}