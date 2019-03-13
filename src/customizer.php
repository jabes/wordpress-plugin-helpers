<?php

class Customizer
{

  static function add_section(WP_Customize_Manager $wp_customize, $id, array $custom_args = null)
  {
    $args = array(
      'title' => '',
      'description' => '',
      'priority' => 160,
      'active_callback' => '',
    );

    if ($custom_args) $args = array_merge($args, $custom_args);
    $wp_customize->add_section($id, $args);
  }

  static function add_setting(WP_Customize_Manager $wp_customize, $id, array $custom_args = null)
  {
    $args = array(
      'default' => '',
      'type' => 'theme_mod', // option, theme_mod
      'capability' => 'edit_theme_options', // https://codex.wordpress.org/Roles_and_Capabilities
      'theme_supports' => '',
      'transport' => 'refresh',
      'sanitize_callback' => '',
      'sanitize_js_callback' => '',
    );

    if ($custom_args) $args = array_merge($args, $custom_args);
    $wp_customize->add_setting($id, $args);
  }

  static function add_control(WP_Customize_Manager $wp_customize, $id, array $custom_args = null)
  {
    $args = array(
      'label' => '',
      'description' => '',
      // DEFAULT SECTIONS
      // themes - <name of the theme>
      // title_tagline - Site Identity
      // colors - Colors
      // header_image - Header Image and Site Icon
      // background_image - Background Image
      // static_front_page - Static Front Page
      'section' => '',
      'priority' => 10,
      'type' => 'text',
      'choices' => array(),
    );

    if ($custom_args) $args = array_merge($args, $custom_args);
    $wp_customize->add_control($id, $args);
  }

}
