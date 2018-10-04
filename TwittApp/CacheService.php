<?php

namespace TwittApp;

use Memcached;

class CacheService
{

  const DATA_TYPE_TRACK_HASHTAGS = 'hashtags';
  const DATA_TYPE_TWEETS         = 'tweets';
  const DATA_TYPE_FOLLOW_TO      = 'followTo';

  const ALL_TYPES = [
    self::DATA_TYPE_TRACK_HASHTAGS,
    self::DATA_TYPE_TWEETS,
    self::DATA_TYPE_FOLLOW_TO,

  ];

  /**
   * @param string $dataType
   * @return mixed
   * @throws \Exception
   */
  public static function getFromMemcached(string $dataType)
  {
    $mc = AppCache::getInstance();

    if ( in_array($dataType, static::ALL_TYPES ) )
    {
       return $mc->get($dataType);
    }
    throw new \Exception('Not defined data type, that trying to get from memcache');
  }

  public static function setToMemcached(string $dataType, $data)
  {
    $mc = AppCache::getInstance();

    $mc->set($dataType, $data);
  }
}
