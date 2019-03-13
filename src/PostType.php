<?php

class PostType
{

  static $support_features = [
    'title',
    'editor',
    'author',
    'thumbnail',
    'excerpt',
    'trackbacks',
    'custom-fields',
    'comments',
    'revisions',
    'page-attributes',
    'post-formats',
  ];

  static function get_default_support_features()
  {
    return PostType::$support_features;
  }

  static function add_support($post_type, $supports)
  {
    add_post_type_support($post_type, $supports);
  }

  static function remove_support($post_type, $supports)
  {
    remove_post_type_support($post_type, $supports);
  }

  static function register($post_type, array $language, array $custom_args = null, $domain = 'default')
  {
    $labels = [
      'name'               => _x($language['plural']['upper'], 'post type general name', $domain),
      'singular_name'      => _x($language['single']['upper'], 'post type singular name', $domain),
      'menu_name'          => _x($language['plural']['upper'], 'admin menu', $domain),
      'name_admin_bar'     => _x($language['single']['upper'], 'add new on admin bar', $domain),
      'add_new'            => _x('Add New', $language['single']['lower'], $domain),
      'add_new_item'       => __('Add New ' . $language['single']['upper'], $domain),
      'new_item'           => __('New ' . $language['single']['upper'], $domain),
      'edit_item'          => __('Edit ' . $language['single']['upper'], $domain),
      'view_item'          => __('View ' . $language['single']['upper'], $domain),
      'all_items'          => __('All ' . $language['plural']['upper'], $domain),
      'search_items'       => __('Search ' . $language['plural']['upper'], $domain),
      'parent_item_colon'  => __('Parent ' . $language['plural']['upper'] . ':', $domain),
      'not_found'          => __('No ' . $language['plural']['lower'] . ' found.', $domain),
      'not_found_in_trash' => __('No ' . $language['plural']['lower'] . ' found in Trash.', $domain),
    ];

    $supports = PostType::get_default_support_features();

    $args = [
      'labels'          => $labels,
      'description'     => '',
      'public'          => true,
      'hierarchical'    => false,
      'show_ui'         => true,
      'menu_position'   => null,
      'menu_icon'       => null,
      'capability_type' => 'post',
      'capabilities'    => [],
      'supports'        => $supports,
      'taxonomies'      => [],
      'has_archive'     => false,
      'rewrite'         => true,
      'query_var'       => $post_type,
    ];

    if ($custom_args) $args = array_merge($args, $custom_args);
    return register_post_type($post_type, $args);
  }

}
