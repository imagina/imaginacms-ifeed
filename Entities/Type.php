<?php

namespace Modules\Ifeeds\Entities;

class Type {
    const RSS = 0;
    const API = 1;
    private $types = [];

    public function __construct() {
      $this->types = [
        [
          'id' => self::RSS,
          'name' => trans('ifeeds::common.types.rss')
        ],
        [
          'id' => self::API,
          'name' => trans('ifeeds::common.types.api')
        ]
      ];
    }

    public function lists() {
        return $this->types;
    }

    public function get($typeId) {
      if (isset($this->types[$typeId])) {
        return $this->types[$typeId];
      }
      return $this->types[self::RSS];
    }
}
