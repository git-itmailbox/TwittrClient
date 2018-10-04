<?php
  $tweets = [];

  $hashtags =[
  '#google'
  ];

  $followTo = [
  '@yuritbox',
];

$mc = new Memcached();
$mc->addServer('localhost',11211);
$mc->set('tweets', $tweets, 36000);
$mc->set('hashtags', $hashtags, 36000);
$mc->set('followTo', $followTo, 36000);
