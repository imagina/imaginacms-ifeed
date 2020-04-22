<?php

namespace Modules\Ifeeds\Repositories\Cache;

use Modules\Ifeeds\Repositories\SourceRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheSourceDecorator extends BaseCacheDecorator implements SourceRepository
{
  public function __construct(SourceRepository $source)
  {
      parent::__construct();
      $this->entityName = 'ifeeds.sources';
      $this->repository = $source;
  }

  /**
   * List or resources
   *
   * @return collection
   */
  public function getItemsBy($params)
  {
    return $this->remember(function () use ($params) {
      return $this->repository->getItemsBy($params);
    });
  }

  /**
   * find a resource by id or slug
   *
   * @return object
   */
  public function getItem($criteria, $params)
  {
    return $this->remember(function () use ($criteria, $params) {
      return $this->repository->getItem($criteria, $params);
    });
  }
}
