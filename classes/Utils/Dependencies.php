<?php

namespace WordPress_WebApp\Utils;

use WordPress_WebApp;

class Dependencies
{
  public static function byURL($url)
  {
    global $wp_scripts;

    WordPress_WebApp\Utils\Debug::log($wp_scripts->queue);
  }
}
