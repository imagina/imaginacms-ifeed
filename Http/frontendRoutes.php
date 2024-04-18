<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Str;

//Router::feeds();
$url = url('/');
$url = str_replace('https://','',$url);
config(['feed.feeds.posts.title' => trans('ifeed::feed.title.titlePosts'). ' ' . $url]);
config(['feed.feeds.products.title' => trans('ifeed::feed.title.titleProducts'). ' ' . $url]);

