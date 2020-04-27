<?php

namespace Modules\Ifeeds\Transformers;

use Illuminate\Http\Resources\Json\Resource;
use Modules\Iprofile\Transformers\UserTransformer;

class SourceTransformer extends Resource
{
  public function toArray($request)
  {
    $data = [
      'id' => $this->when($this->id, $this->id),
      'name' => $this->when($this->name, $this->name),
      'url' => $this->when($this->url, $this->url),
      'type' => $this->type,
      'status' => $this->status,
      'userId' => $this->when($this->user_id, $this->user_id),
      'options' => $this->when($this->options, $this->options),
      'user' => new UserTransformer($this->whenLoaded('user')),
    ];

    return $data;
  }
}
