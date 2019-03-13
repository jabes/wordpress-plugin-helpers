<?php

class Customizer
{

  // WordPress does include a few built-in sections.
  // If you want to use any of the existing, built-in ones,
  // you don't need to declare them with add_section().
  // Instead, refer to them directly.
  // The following sections are built-in...
  static $sections = [
    'themes'            => 'themes', // <name of the theme>
    'title_tagline'     => 'title_tagline', // Site Identity
    'colors'            => 'colors', // Colors
    'header_image'      => 'header_image', // Header Image and Site Icon
    'background_image'  => 'background_image', // Background Image
    'static_front_page' => 'static_front_page', // Static Front Page
  ];

  static function add_section(WP_Customize_Manager $wp_customize, $id, array $custom_args = null)
  {
    $args = [
      'title'           => '',
      'description'     => '',
      'priority'        => 160,
      'active_callback' => '',
    ];

    if ($custom_args) $args = array_merge($args, $custom_args);
    $wp_customize->add_section($id, $args);
  }

  static function add_setting(WP_Customize_Manager $wp_customize, $id, array $custom_args = null)
  {
    $args = [
      'default'              => '',
      'type'                 => 'theme_mod', // option, theme_mod
      'capability'           => 'edit_theme_options', // https://codex.wordpress.org/Roles_and_Capabilities
      'theme_supports'       => '',
      'transport'            => 'refresh',
      'sanitize_callback'    => '',
      'sanitize_js_callback' => '',
    ];

    if ($custom_args) $args = array_merge($args, $custom_args);
    $wp_customize->add_setting($id, $args);
  }

  static function add_control(WP_Customize_Manager $wp_customize, $id, array $custom_args = null)
  {
    $args = [
      'label'       => '',
      'description' => '',
      'section'     => '',
      'priority'    => 10,
      'type'        => 'text',
      'choices'     => [],
    ];

    if ($custom_args) $args = array_merge($args, $custom_args);
    $wp_customize->add_control($id, $args);
  }

}
