<?php

namespace WordPress_WebApp\Endpoints;

class Manifest
{
  const ENDPOINT = '/manifest.json';
  const PLACES = EP_ROOT;

  public static function init()
  {
    $class = new self;

    add_rewrite_endpoint(self::ENDPOINT, self::PLACES);

    add_action('template_redirect', [$class, 'response']);
  }

  public function response()
  {
    $request = $_SERVER['REQUEST_URI'];

    if (self::ENDPOINT === $request) {
      status_header(200);
      $response = self::generate();

      echo json_encode($response);
      exit;
    }
  }

  function generate()
  {
    $name = get_bloginfo('name');
    $shortName = false;
    $url = get_bloginfo('url');

    $manifest = [
      'name' => $name,
      'short_name' => $shortName ?: $name,
      'icons' => [
        [
          "src" => "https://one.lancejernigan.com/assets/icons/icon-192.png",
          "sizes" => "192x192",
          "type" => "image/png"
        ],
        [
          "src" => "https://one.lancejernigan.com/assets/icons/icon-512.png",
          "type" => "image/png",
          "sizes" => "512x512"
        ]
      ],
      'start_url' => '/',
      'theme_color' => '#fff',
      'background_color' => '#fff',
      'display' => 'standalone',
      'orientation' => 'portrait',
    ];

    return $manifest;
  }
}
