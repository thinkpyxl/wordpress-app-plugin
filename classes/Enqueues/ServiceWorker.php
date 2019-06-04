<?php

namespace WordPress_WebApp\Enqueues;

use WordPress_WebApp\Utils\Debug;

class ServiceWorker
{
  public static function init()
  {
    $class = new self;

    add_action('wp_head', [$class, 'render']);
  }

  public function render()
  {
    $route = $_SERVER['REQUEST_URI'];

    echo "<script>if ('serviceWorker' in navigator) {window.addEventListener('load', () => {navigator.serviceWorker.register('/service-worker?route=${route}');});}</script>";
  }
}
