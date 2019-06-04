<?php

namespace WordPress_WebApp\Enqueues;

class Manifest
{
  public static function init()
  {
    $class = new self;

    add_action('wp_head', [$class, 'render']);
  }

  public function render()
  {
    echo '<link rel="manifest" href="/manifest.json">';
  }
}
