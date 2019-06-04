<?php

namespace WordPress_WebApp\Caches;

use WordPress_WebApp\Utils\Debug;
use WordPress_WebApp\PostTypes\Caches;

class StoreCache
{
  public static $srcs = [];
  public static $slug = '';

  public static function init()
  {
    $class = new self;

    self::$slug = $_SERVER['REQUEST_URI'];

    add_filter('script_loader_src', [$class, 'loader'], 100, 2);
    add_filter('style_loader_src', [$class, 'loader'], 100, 2);
    add_action('shutdown', [$class, 'store_enqueues']);
  }

  public function loader($src, $handle)
  {
    array_push(self::$srcs, $src);

    return $src;
  }

  public function store_enqueues()
  {
    $route = self::$slug;
    $assets = json_encode(self::$srcs);

    $caches = Caches::get([
      'post_status' => 'draft',
      'meta_query' => [
        [
          'key' => 'route',
          'value' => $route,
        ]
      ]
    ]);
    $cache = array_pop($caches);
    $cacheId = $cache
      ? $cache->ID
      : 0;

      Debug::log($cache);

    Caches::update(
      $cacheId,
      [
        'route' => $route,
        'assets' => $assets,
      ]
    );
  }
}
