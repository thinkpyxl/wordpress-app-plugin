<?php

/**
 * Plugin Name: WordPress Web App
 * Description: Plugin for providing web apps with WordPress
 * Version: 1.0.0
 * Author: Lance Jernigan
 * Author URI: https://lancejernigan.com
 * License: GPLv3+
 */

namespace WordPress_WebApp;

require_once 'lib/autoload.php';

define(__NAMESPACE__ . '\PATH', trailingslashit(dirname(__FILE__)));

add_action(
  'init',
  function() {
    PostTypes\Caches::init();

    Caches\PreCache::init();
    Caches\StoreCache::init();

    Enqueues\Manifest::init();
    Enqueues\ServiceWorker::init();

    Endpoints\Manifest::init();
    Endpoints\PreCache::init();
    Endpoints\ServiceWorker::init();

    // OptionPages\Plugin::init();
  }
);