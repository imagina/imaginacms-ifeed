<?php

namespace Modules\Ifeeds\Transformers;

use Illuminate\Http\Resources\Json\Resource;

class FeedTransformer extends Resource
{
  public function toArray($request)
  {

    $filter = json_decode($request->filter);

    $data = [];

    foreach ($filter->fields as $field){
      if(!empty($field)){
        $data[$field] = $this[$field];
      }
    }

    return $data;
  }
}