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
      'title' => $this->title ?? 'title_post_'.$this->id,
      'summary' => $this->summary ?? 'summary_post_'.$this->id,
      'authorName' => $this->user->present()->fullname ?? 'author_post_'.$this->id,
      'updated' => $this->updated_at ?? 'date_updated_post_'.$this->id,
      'link' => $this->url ?? 'url_post_'.$this->id,
      'status' => $this->status ?? 'status_post_'.$this->id,
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
