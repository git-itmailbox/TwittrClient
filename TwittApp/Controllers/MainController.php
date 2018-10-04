<?php
/**
 * Created by PhpStorm.
 * User: yura
 * Date: 03.10.18
 * Time: 19:28
 */

namespace TwittApp\Controllers;


use Memcached;
use TwittApp\CacheService;

class MainController
{
  /**
   * change trqcking hashtag Action
   */
  public static function addTrack($hashtag)
  {
    $mc = new Memcached();
    $mc->addServer('localhost', 11211);

    $newhastag = '#'.$hashtag;

    $cachedHashtags = $mc->get(CacheService::DATA_TYPE_TRACK_HASHTAGS);

    if($cachedHashtags && is_array($cachedHashtags) && !in_array($newhastag, $cachedHashtags))
    {
      $cachedHashtags[] = $newhastag;
    }
    if ($cachedHashtags && !is_array($cachedHashtags))
    {
      $cachedHashtags = [$cachedHashtags, $newhastag];
    }

    $mc->set(CacheService::DATA_TYPE_TRACK_HASHTAGS, $cachedHashtags);

    http_response_code(201);

    echo 'succesfull';

  }

}
