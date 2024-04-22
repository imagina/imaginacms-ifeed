<?php

namespace Modules\Ifeed\Entities;

use Modules\Icommerce\Entities\Product as EntityProducts;
use Spatie\Feed\Feedable;
use Spatie\Feed\FeedItem;
use Illuminate\Http\Request;

use Modules\Icommerce\Repositories\ProductRepository;

class Product extends EntityProducts implements Feedable
{

  public function toFeedItem(): FeedItem
  {

    //Get Image
    $image = $this->files->first(function ($item) { return $item->pivot->zone=='mainimage';});

    //Final Data
    return FeedItem::create([
      'id' => $this->id,
      'title' => $this->name,
      'summary' => $this->description,
      'author' => '',
      'updated' => $this->updated_at,
      'link' => $this->url,
      'description' => $this->description,
      'availability' => $this->stock_status ? 'in stock' : 'out of stock',
      'condition' => 'new',
      'price' => isiteFormatMoney($this->price, true, 'asgard.ifeed.config.formatMoney'),
      'image_link' => url($image->path ?? 'modules/icommerce/img/product/default.jpg'),
      'brand' => $this->category->title ?? '-',
    ]);

  }

  /**
   * 
   */
  public static function getFeedItems(Request $request)
  {

    //Limit
    $params = ifeedGetParamsToProducts($request);
   
    //Repository Call
    $productItems = app("Modules\Icommerce\Repositories\ProductRepository")->getItemsBy(json_decode(json_encode(($params))));
    
    //Map the products as a current Product model
    $feedableItems = $productItems->map(function ($item) {
      $product = new Product($item->toArray());
      $product->id = $item->id;
      $product->updated_at = $item->updated_at;
      //Preserve needed relations
      if ($item->relationLoaded('files')) $product->setRelation('files', $item->files);
      if ($item->relationLoaded('category')) $product->setRelation('category', $item->category);
      //Response
      return $product;
    });

    return $feedableItems;

  }

 

}
