<?php

namespace WordPress_WebApp\Caches;

use WordPress_WebApp\Utils\Debug;
use WordPress_WebApp\PostTypes\Caches;

class PreCache
{
  public static function init()
  {
    $class = new self;

    add_filter('register_cache', [$class, 'currentRoute']);
    add_filter('register_cache', [$class, 'otherRoutes']);
  }

  public function currentRoute($caches) {
    $route = $_GET['route'];
    $cache = Caches::getByRoute($route);
    $assetsJSON = get_post_meta($cache->ID, 'assets', true);
    $assets = \json_decode($assetsJSON);

    $caches = array_merge(
      [
        $route
      ],
      $caches,
      $assets
    );

    return $caches;
  }

  public function otherRoutes($caches)
  {
    $post = Caches::getByRoute('/asfasdf/');
    $postAssetsJSON = get_post_meta($post->ID, 'assets', true);
    $postAssets = \json_decode($postAssetsJSON);

    $caches = array_merge(
      [
        '/asfasdf/',
      ],
      $caches,
      $postAssets
    );

    return $caches;
  }
}
