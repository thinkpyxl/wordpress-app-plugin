<?php

namespace WordPress_WebApp\OptionPages;

class Plugin
{
  public static $CLASS = false;
  const PAGE_TITLE = 'Web App Settings';
  const MENU_TITLE = 'Web App Settings';
  const CAPABILITIES = 'edit_posts';
  const SLUG = 'wep_app_settings';
  const ICON = '';
  const POSITION = 300;

  public static function init()
  {
    if (!self::$CLASS) {
      self::$CLASS = new self;
    }

    add_action('admin_menu', [self::$CLASS, 'register']);
  }

  public function register()
  {
    add_menu_page(
      self::PAGE_TITLE,
      self::MENU_TITLE,
      self::CAPABILITIES,
      self::SLUG,
      [self::$CLASS, 'render'],
      self::ICON,
      self::POSITION
    );
  }

  public function render()
  {
    echo 'plugin option page';
  }
}
