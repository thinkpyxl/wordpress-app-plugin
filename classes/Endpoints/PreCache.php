<?php

namespace WordPress_WebApp\Endpoints;

use WordPress_WebApp;
use WordPress_WebApp\Utils\Debug;

class PreCache
{
  const ENDPOINT = '/pre-cache';
  const PLACES = EP_ROOT;

  public static function init()
  {
    $class = new self;

    add_rewrite_endpoint(self::ENDPOINT . '\?route=.+', self::PLACES);

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
    $caches = \apply_filters('register_cache', []);
    $cachesJSON = \json_encode($caches);
    $preCache = "self.__precacheManifest = ${cachesJSON}";

    // WordPress_WebApp\Utils\Debug::log($caches);

    return $preCache;
  }
}
