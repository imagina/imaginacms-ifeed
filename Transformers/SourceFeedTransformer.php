<?php

namespace Modules\Ifeeds\Transformers;

use Illuminate\Http\Resources\Json\Resource;
use Modules\Ifeeds\Support\Facades\Rss;

class SourceFeedTransformer extends Resource
{
  public function toArray($request)
  {

    $originalData = collect(Rss::parse($this->url));
    $originalDataItem = collect($originalData['item']);
    $sourceConfigTransform = $this->options['source'];
    $itemConfigTransform = $this->options['item'];
    $data = [];

    foreach ($sourceConfigTransform as $key => $sourceTransform) {
      if ($originalData->has($sourceTransform) && gettype($originalData[$sourceTransform]) == 'string'){
        $data[$key] = $originalData[$sourceTransform];
      } else {
        $args = explode('.',$sourceTransform);
        $data[$key] = $this->getValue($args, $originalData);
      }
    }

    foreach ($originalDataItem as $key => $item){
      foreach ($itemConfigTransform as $k => $itemTransform) {
        $originalItem = collect($item);
        if ($originalItem->has($itemTransform) && gettype($originalItem[$itemTransform]) == 'string'){
          $data['item'][$key][$k] = $originalItem[$itemTransform];
        } else {
          $args = explode('.',$itemTransform);
          $data['item'][$key][$k] = $this->getValue($args, $originalItem);;
        }
      }
    }

    return $data;
  }

  public function getValue ($args, $originalData) {
    $response = '';
    $tmp = $originalData;
    for ($i = 0; $i < count($args); $i++){
      if ( !(collect($tmp)->has($args[$i])) ){
        return false;
      }
      $tmp = collect($tmp)[$args[$i]];
    }
    return $tmp;
  }

}