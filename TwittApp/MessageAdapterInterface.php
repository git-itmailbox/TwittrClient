<?php

namespace TwittApp;


interface MessageAdapterInterface
{
  public function getFormattedMessage(array $data);
}
