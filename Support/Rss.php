<?php

namespace Modules\Ifeeds\Support;

class rss
{

  public function Parse ($url) {
    $simpleXml = simplexml_load_file($url, "SimpleXMLElement", LIBXML_NOCDATA);
    $json = json_decode(json_encode($simpleXml))->channel;
    return $json;
  }

}