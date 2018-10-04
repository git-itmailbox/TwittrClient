<?php
/**
 * Created by PhpStorm.
 * User: yura
 * Date: 04.10.18
 * Time: 9:44
 */

namespace TwittApp;


use Memcached;
use Spatie\TwitterStreamingApi\PublicStream;

class TwitterStream implements MessageAdapterInterface
{
  //limit for displaying and storing in cache
  private const MESSAGE_LIMIT=25;

  private $twtrConfig;
  private $pusher;
  private $mc;
  /**
   * TwitterStream constructor.
   */
  public function __construct(array $twtrConfig)
  {
    $this->twtrConfig = $twtrConfig;
    $options = array(
      'cluster' => 'eu',
      'useTLS' => true
    );
    $this->pusher = new \Pusher\Pusher(
      'b33fef1f27e4946a4e83',
      '353a04c4dc85f7b45bd5',
      '613358',
      $options
    );

    $this->mc = new Memcached();
    $this->mc->addServer('localhost', 11211);
  }

  public function getFormattedMessage(array $data)
  {
    $_tweet = [
      'text'         =>  $data['text'],
      'user'        => [
        'screen_name'       => $data['user']['screen_name'],
        'name'              => $data['user']['name'],
        'id'                => $data['user']['id'],
        'profile_image_url' => $data['user']['profile_image_url'],
        'folowers_count'    => $data['user']['folowers_count'],
      ],
      'created_at'  => $data['created_at'],
    ];

    return $_tweet;
  }

  private function getHashtag()
  {
    return $this->mc->get(CacheService::DATA_TYPE_TRACK_HASHTAGS)??'#google';
  }

  public function run()
  {
    $mc = $this->mc;
    $pusher = $this->pusher;
    PublicStream::create(
      $this->twtrConfig['oauthTokenToken'],
      $this->twtrConfig['oauthTokenSecret'],
      $this->twtrConfig['consumerKey'],
      $this->twtrConfig['consumerSecret'])
      ->whenHears($this->getHashtag(), function (array $tweet) use ($pusher , $mc){
//  ->whenTweets(['@yuritbox'], function (array $tweet) use ($pusher, $hashtags, $followTo) {
        $_tweet = $this->getFormattedMessage($tweet);
        //get tweets from cache and add to them one more
        $tweets = $mc->get(\TwittApp\CacheService::DATA_TYPE_TWEETS);

        if(!$tweets)
        {
          $tweets = [$_tweet];
        }
        else
        {
          $tweets = array_reverse($tweets);
          $tweets[] = $_tweet;
        }
        //delete old messages if array is bigger than limit
        while(count($tweets) > self::MESSAGE_LIMIT)
        {
          array_shift($tweets);
        }

        $tweets = array_reverse($tweets);

        $mc->set(\TwittApp\CacheService::DATA_TYPE_TWEETS, $tweets);
        $data['hashtags'] = $mc->get(\TwittApp\CacheService::DATA_TYPE_TRACK_HASHTAGS);
        $data['followTo'] = $mc->get(\TwittApp\CacheService::DATA_TYPE_FOLLOW_TO);
        $data['tweets'] = $tweets;
        $this->pusher->trigger('my-channel', 'my-event', $data);

      })
      ->checkFilterPredicates(function($stream) use ($pusher , $mc) {
        $trackIds = $mc->get(CacheService::DATA_TYPE_TRACK_HASHTAGS);
        if ($trackIds != $stream->getTrack()) {
          $stream->setTrack($trackIds);

          $data = [
            'hashtags'  => $mc->get(\TwittApp\CacheService::DATA_TYPE_TRACK_HASHTAGS),
            'followTo'  => $mc->get(\TwittApp\CacheService::DATA_TYPE_FOLLOW_TO),
            'tweets'    => $mc->get(\TwittApp\CacheService::DATA_TYPE_TWEETS),
          ];


          $this->pusher->trigger('my-channel', 'my-event', $data);

        }
      })
      ->startListening();

  }


}


