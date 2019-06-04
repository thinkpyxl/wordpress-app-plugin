<?php

namespace WordPress_WebApp\Endpoints;

use WordPress_WebApp;
use WordPress_WebApp\Utils\Debug;

class ServiceWorker
{
  const ENDPOINT = '/service-worker';
  const PLACES = EP_ROOT;

  public static function init()
  {
    $class = new self;

    add_rewrite_endpoint(self::ENDPOINT . '\?route=.+', self::PLACES, true);

    add_filter('wp_headers', [$class, 'headers']);
    add_action('template_redirect', [$class, 'response']);
  }

  public function headers($headers)
  {
    $request = explode('?', $_SERVER['REQUEST_URI']);

    if (self::ENDPOINT === $request[0]) {
      $headers['Content-Type'] = 'text/javascript;';
    }

    return $headers;
  }

  public function response()
  {
    $request = explode('?', $_SERVER['REQUEST_URI']);

    if (self::ENDPOINT === $request[0]) {
      status_header(200);
      $response = self::generate();

      echo $response;
      exit;
    }
  }

  function generate()
  {
    $regex = '/\<\.(.+)\.\>/';
    $serviceWorker = \file_get_contents(WordPress_WebApp\PATH . './assets/js/service-worker.js');
    preg_match_all($regex, $serviceWorker, $matches);

    for ($m = 0; $m < sizeof($matches[0]); $m++) {
      $match = $matches[1][$m];
      $needle = $matches[0][$m];
      $value = 'route' === $match
        ? array_key_exists('route', $_GET)
          ? $_GET['route']
          : ''
        : '';
      $serviceWorker = str_replace($needle, $value, $serviceWorker);
    }

    return $serviceWorker;
  }
}
