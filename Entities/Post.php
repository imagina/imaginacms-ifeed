<?php

namespace Modules\Ifeed\Entities;

use Modules\Iblog\Entities\Post as EntityPost;
use Spatie\Feed\Feedable;
use Spatie\Feed\FeedItem;
use Astrotomic\Translatable\Translatable;
use Illuminate\Http\Request;

class Post extends EntityPost implements Feedable
{

  public function toFeedItem(): FeedItem
  {
    return FeedItem::create([
      'id' => $this->id,
      'title' => $this->title,
      'summary' => $this->summary,
      'author' => $this->user->present()->fullname,
      'updated' => $this->updated_at,
      'link' => $this->url,
      'status' => $this->status,
    ]);
  }

  public static function getFeedItems(Request $request)
  {

    //Limit
    $params = ifeedGetParamsToItems($request,'Posts');

    //Repository Call
    $postItems = app("Modules\Iblog\Repositories\PostRepository")->getItemsBy(json_decode(json_encode(($params))));

    //Map the products as a current Product model
    $feedableItems = $postItems->map(function ($item) {
      $post = new Post($item->toArray());
      $post->id = $item->id;
      $post->updated_at = $item->updated_at;
      //Preserve needed relations
      if ($item->relationLoaded('user')) $post->setRelation('user', $item->user);
     
      //Response
      return $post;
    });

    return $feedableItems;

  }
}
