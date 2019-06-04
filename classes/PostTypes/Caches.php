<?php

namespace WordPress_WebApp\PostTypes;

use WordPress_WebApp\Utils\Debug;

class Caches
{

    const SLUG = 'wp_wa_caches';

    const SINGULAR = 'Cache';

    const PLURAL = 'Caches';

    const ICON = 'dashicons-groups';

    public static function init()
    {
        $class = new self;

        self::register();
    }

    public static function register()
    {
        $labels = [
            'name'               => self::PLURAL,
            'single_name'        => self::SINGULAR,
            'add_new_item'       => 'Add New '.self::SINGULAR,
            'edit_item'          => 'Edit '.self::SINGULAR,
            'new_item'           => 'New '.self::SINGULAR,
            'all_items'          => 'All '.self::PLURAL,
            'view_item'          => 'View '.self::SINGULAR,
            'search_items'       => 'Search '.self::PLURAL,
            'not_found'          => 'No '.strtolower(self::PLURAL).' found',
            'not_found_in_trash' => 'No '.strtolower(self::PLURAL).' found in the Trash',
            'parent_item_colon'  => '',
            'menu_name'          => self::PLURAL,
        ];
        $args   = [
            'menu_icon'          => self::ICON,
            'labels'             => $labels,
            'public'             => true,
            'publicly_queryable' => true,
            'has_archive'        => true,
            'show_ui'            => true,
            'show_in_nav_menus'  => true,
            'hierarchical'       => false,
            // 'menu_position'      => 15,
            'rewrite'            => [
                'slug'       => strtolower(self::PLURAL),
                'with_front' => false,
            ],
            'map_meta_cap'       => true,
            'supports'           => [
                'title',
            ],
            'show_in_rest'       => true,
        ];

        register_post_type(self::SLUG, $args);
    }

    public static function get($args = []) {
      $_args = [
        'post_type' => self::SLUG,
      ];
      $args = array_merge(
        [],
        $args,
        $_args
      );
      $query = new \WP_Query($args);

      return $query->posts;
    }

    public static function create($meta) {
      self::update(0, $meta);
    }

    public static function update($id, $meta) {
      wp_insert_post([
        'ID' => $id,
        'post_type' => self::SLUG,
        'meta_input' => $meta,
      ]);
    }

    public static function getByRoute($route) {
      $caches = self::get([
        'post_status' => 'draft',
        'meta_query' => [
          [
            'key' => 'route',
            'value' => $route,
          ]
        ]
      ]);

      return array_pop($caches);
    }
}