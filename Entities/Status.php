<?php

namespace Modules\Ifeeds\Entities;

class Status {
  const DRAFT = 0;
  const PENDING = 1;
  const PUBLISHED = 2;
  const UNPUBLISHED = 3;

  private $statuses = [];

  public function __construct() {
    $this->statuses = [
      [
        'id' => self::DRAFT,
        'name' => trans('ifeeds::common.status.draft')
      ],
      [
        'id' => self::PENDING,
        'name' => trans('ifeeds::common.status.pending')
      ],
      [
        'id' => self::PUBLISHED,
        'name' => trans('ifeeds::common.status.published')
      ],
      [
        'id' => self::UNPUBLISHED,
        'name' => trans('ifeeds::common.status.unpublished')
      ]
    ];
  }

  public function lists() {
    return $this->statuses;
  }

  public function get($statusId) {
    if (isset($this->statuses[$statusId])) {
      return $this->statuses[$statusId];
    }
    return $this->statuses[self::DRAFT];
  }
}
