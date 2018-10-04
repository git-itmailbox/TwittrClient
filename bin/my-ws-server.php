<?php

use Spatie\TwitterStreamingApi\PublicStream;
use TwittApp\TwitterStream;

require_once dirname(__DIR__).'/configs/twt_config.php';
require_once dirname(__DIR__).'/vendor/autoload.php';
require_once 'init.php';

$twtrConfig = [
  'consumerKey' => 'zcGocWQZTrcgxpv8t58gZwEZt',
  'consumerSecret' => 'bl9VHA4yerb5M8iQcVQ8bZdSoRDpDQhFzTSbspeU2JE6D8WAgb',
  'oauthTokenToken' => '1045277291973152770-4NHsu1G4cObhDg667zhFa2QNUcaJdH',
  'oauthTokenSecret' => '6K7jSDNRO0XQgRGKDeQujFjo9up2QiJ2noeNPVfWAgkX5'
];



$messageSystem = 'Twitter';
switch ($messageSystem){

  case 'Other_System':
    throw new Exception('Message system for '. $messageSystem.' Not implemented');
    break;

  case 'Twitter':
  default:
    $stream = new TwitterStream($twtrConfig);

}
$stream->run();

//
//PublicStream::create(
//  $twtrConfig['oauthTokenToken'],
//  $twtrConfig['oauthTokenSecret'],
//  $twtrConfig['consumerKey'],
//  $twtrConfig['consumerSecret'])
//  ->whenHears($hashtags, function (array $tweet) use ($pusher, $mc){
////  ->whenTweets(['@yuritbox'], function (array $tweet) use ($pusher, $hashtags, $followTo) {
//
//    $_tweet = [
//     'text'         =>  $tweet['text'],
//      'user'        => [
//          'screen_name'       => $tweet['user']['screen_name'],
//          'name'              => $tweet['user']['name'],
//          'id'                => $tweet['user']['id'],
//          'profile_image_url' => $tweet['user']['profile_image_url'],
//          'folowers_count'    => $tweet['user']['folowers_count'],
//          ],
//      'created_at'  => $tweet['created_at'],
//    ];
//
//    $tweets = $mc->get(\TwittApp\CacheService::DATA_TYPE_TWEETS);
//
//    if(!$tweets)
//    {
//      $tweets = [$_tweet];
//    }
//    else
//    {
//      $tweets = array_reverse($tweets);
//      $tweets[] = $_tweet;
//    }
//
//    while(count($tweets)>25)
//    {
//      array_shift($tweets);
//    }
//
//    $tweets = array_reverse($tweets);
//
//    $mc->set(\TwittApp\CacheService::DATA_TYPE_TWEETS, $tweets);
//    $data['hashtags'] = $mc->get(\TwittApp\CacheService::DATA_TYPE_TRACK_HASHTAGS);
//    $data['followTo'] = $mc->get(\TwittApp\CacheService::DATA_TYPE_FOLLOW_TO);
//    $data['tweets'] = $tweets;
//    $pusher->trigger('my-channel', 'my-event', $data);
//
//  })->startListening();
//
