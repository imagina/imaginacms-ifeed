<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['doNotCacheResponse']], function () {
  Router::feeds();
});
$url = url('/');
$url = str_replace('https://', '', $url);
config(['feed.feeds.posts.title' => trans('ifeed::feed.title.titlePosts') . ' ' . $url]);
config(['feed.feeds.products.title' => trans('ifeed::feed.title.titleProducts') . ' ' . $url]);

