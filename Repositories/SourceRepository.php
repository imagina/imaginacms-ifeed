<?php

namespace Modules\Ifeeds\Repositories;

use Modules\Core\Repositories\BaseRepository;

interface SourceRepository extends BaseRepository
{
  public function getItemsBy($params);

  public function getItem($criteria, $params);
}
