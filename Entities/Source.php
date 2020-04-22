<?php

namespace Modules\Ifeeds\Entities;

use Illuminate\Database\Eloquent\Model;

class Source extends Model
{
  protected $table = 'ifeeds__sources';

  protected $fillable = [
    'name',
    'url',
    'type',
    'status',
    'user_id',
    'options',
  ];

  protected $casts = [
    'options' => 'array'
  ];

  public function user()
  {
    $driver = config('asgard.user.config.driver');

    return $this->belongsTo("Modules\\User\\Entities\\{$driver}\\User");
  }
}
