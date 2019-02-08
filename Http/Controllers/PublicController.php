<?php
namespace Modules\Ifeeds\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Modules\Core\Http\Controllers\BasePublicController;
use Modules\Iblog\Entities\Post as Post;


class PublicController extends BasePublicController
{
    public function feed($format)
    {

        //Rss disabled.
        if( empty($format) || config('asgard.ifeeds.config.activated') != true ) {
            abort(404);
        };

        $post_per_feed = config('asgard.ifeed.config.posts_per_feed',20);
        $feed_logo = config('asgard.ifeed.config.logo');


        /* create new feed */
        $feed = \App::make("feed");

        //Default Template or check if in available formats
        $tpl = "ifeed::frontend.feed.{$format}";
        $ttpl="ifeed.feed.{$format}";
        if(view()->exists($ttpl)) $tpl = $ttpl;


        if(view()->exists($tpl)) {
            $feed->setView($tpl);
        } else {
            if(!in_array($format,['rss','atom'])) abort(404);
        }

        $posts = Post::query()->where('status',Status::PUBLISHED)->orderBy('created_at','desc')->limit($post_per_feed)->get();

        $feed->title = setting('core::site-name');
        $feed->description = setting('core::site-description');
        $feed->logo = $feed_logo;
        $feed->link = url('feed/'.$format);
        $feed->setDateFormat('datetime');
        $feed->pubdate = $posts[0]->created_at;
        $feed->lang = \LaravelLocalization::getCurrentLocale();
        //$feed->setShortening(true);
        //$feed->setTextLimit(100);


        foreach ($posts as $post)
        {


            $item = ['title'=>$post->title, 'author'=>$post->author, 'link'=>$post->url, 'pubdate'=>$post->created_at, 'description'=>$post->summary, 'content'=>$post->description];
            switch($format) {
                case 'facebook':

                    $item['op-published-time'] = strtotime($post->created_at->toDateTimeString());
                    $item['op-modified-time'] = strtotime($post->updated_at->toDateTimeString());
                    $item['mainimage'] = url($post->options->mainimage);

                    $item['author_name'] = "{$post->user->first_name} {$post->user->last_name} ";
                    $item['author_desc'] = "{$post->user->desc}";

                    //Let's remove all h3-4-5-6 tags for h2.
                    $item['content'] = preg_replace("#<h[3-9]>#is", "<h2>", $item['content']);
                    $item['content'] = preg_replace("#</h[3-9]>#is", "</h2>", $item['content']);

                    break;
            }

            $feed->setItem($item);

        }

        return $feed->render($format);

    }

}