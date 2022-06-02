<?php

namespace Modules\Ifeed\Repositories\Cache;

use Modules\Ifeed\Repositories\FeedRepository;
use Modules\Core\Icrud\Repositories\Cache\BaseCacheCrudDecorator;

class CacheFeedDecorator extends BaseCacheCrudDecorator implements FeedRepository
{
    public function __construct(FeedRepository $feed)
    {
        parent::__construct();
        $this->entityName = 'ifeed.feeds';
        $this->repository = $feed;
    }
}
