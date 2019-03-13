<?php

class Taxonomy
{

  static function register($taxonomy, $object_type, array $language, array $custom_args = null, $domain = 'default')
  {
    // names should only contain lowercase letters and the underscore character
    // and not be more than 32 characters long
    // (database structure restriction)
    if (strlen($taxonomy) > 32) return false;
    $taxonomy = strtolower($taxonomy);
    $taxonomy = str_replace(' ', '_', $taxonomy);
    $taxonomy = preg_replace("/[^a-z_]/", '', $taxonomy);

    $labels = array(
      'name'              => _x($language['plural']['upper'], 'taxonomy general name', $domain),
      'singular_name'     => _x($language['single']['upper'], 'taxonomy singular name', $domain),
      'search_items'      => __('Search ' . $language['plural']['upper'], $domain),
      'all_items'         => __('All ' . $language['plural']['upper'], $domain),
      'parent_item'       => __('Parent ' . $language['single']['upper'], $domain),
      'parent_item_colon' => __('Parent ' . $language['single']['upper'] . ':', $domain),
      'edit_item'         => __('Edit ' . $language['single']['upper'], $domain),
      'update_item'       => __('Update ' . $language['single']['upper'], $domain),
      'add_new_item'      => __('Add New ' . $language['single']['upper'], $domain),
      'new_item_name'     => __('New ' . $language['single']['upper'] . ' Name', $domain),
      'menu_name'         => __($language['single']['upper'], $domain),
    );

    $args = array(
      'labels'            => $labels,
      'description'       => '',
      'public'            => true,
      'hierarchical'      => false,
      'show_ui'           => true,
      'show_admin_column' => true,
      'capabilities'      => array(),
      'rewrite'           => true,
      'query_var'         => $taxonomy,
    );

    if ($custom_args) $args = array_merge($args, $custom_args);
    return register_taxonomy($taxonomy, $object_type, $args);
  }

  static function insert_terms($taxonomy, array $terms)
  {
    foreach ($terms as $term) {
      // note: terms should only be inserted once
      if (term_exists($term, $taxonomy)) continue;
      wp_insert_term($term, $taxonomy);
    }
  }

}
