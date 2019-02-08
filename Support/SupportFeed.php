<?php

namespace Modules\Ifeeds\Support;



class SupportFeed
{

    public $entity;
    public $format;
    
    
    public function __construct($format, $entity)
    {
        $this->entity=$entity;
        $this->format=$format;
    }

    public function feed($feed_logo)
    {

        //Rss disabled.
        if (empty($this->format) || config('asgard.ifeeds.config.activated') != true) {
            abort(404);
        };

      //$post_per_feed = config('asgard.ifeed.config.posts_per_feed', 20);
        //$feed_logo = config('asgard.ifeed.config.logo');


        /* create new feed */
        $feed = \App::make("feed");

        //Default Template or check if in available formats
        $tpl = "ifeed::frontend.feed.{$this->format}";
        $ttpl = "ifeed.feed.{$this->format}";
        if (view()->exists($ttpl)) $tpl = $ttpl;


        if (view()->exists($tpl)) {
            $feed->setView($tpl);
        } else {
            if (!in_array($this->format, ['rss', 'atom'])) abort(404);
        }

      //  $posts = Post::query()->where('status', Status::PUBLISHED)->orderBy('created_at', 'desc')->limit($post_per_feed)->get();

        $feed->title = setting('core::site-name');
        $feed->description = setting('core::site-description');
        $feed->logo = $feed_logo;
        $feed->link = url('feed/' . $this->format);
        $feed->setDateFormat('datetime');
        $feed->pubdate = $this->entity->first()->created_at;
        $feed->lang = \LaravelLocalization::getCurrentLocale();
        //$feed->setShortening(true);
        //$feed->setTextLimit(100);


        foreach ($this->entity as $field) {


            $item = ['title' => $field->title, 'author' => $field->author, 'link' => $field->url, 'pubdate' => $field->created_at, 'description' => $field->summary, 'content' => $field->description];
            switch ($this->format) {
                case 'facebook':

                    $item['op-published-time'] = strtotime($field->created_at->toDateTimeString());
                    $item['op-modified-time'] = strtotime($field->updated_at->toDateTimeString());
                    $item['mainimage'] = url($field->options->mainimage);

                    $item['author_name'] = "{$field->user->first_name} {$field->user->last_name} ";
                    $item['author_desc'] = "{$field->user->desc}";

                    //Let's remove all h3-4-5-6 tags for h2.
                    $item['content'] = preg_replace("#<h[3-9]>#is", "<h2>", $item['content']);
                    $item['content'] = preg_replace("#</h[3-9]>#is", "</h2>", $item['content']);

                    break;
            }

            $feed->setItem($item);

        }

        return $feed->render($this->format);

    }

}