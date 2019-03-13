<?php

class FieldSettings
{

  static $generic = [
    'key' => '',
    'label' => '',
    'name' => '',
    'type' => 'text',
    'order_no' => 1,
    'instructions' => '',
    'required' => 0,
    'id' => '',
    'class' => '',
    'conditional_logic' => [
      'status' => 0,
      'allorany' => 'all',
      'rules' => 0
    ]
  ];

  // Basic
  //----------------------------------------------------------------------------------------------------------------------

  static $text = [
    'default_value' => '',
    'maxlength' => '',
    'placeholder' => '',
    'prepend' => '',
    'append' => ''
  ];

  static $textarea = [
    'default_value' => '',
    'new_lines' => '',
    'maxlength' => '',
    'placeholder' => '',
    'rows' => ''
  ];

  static $number = [
    'default_value' => '',
    'min' => '',
    'max' => '',
    'step' => '',
    'placeholder' => '',
    'prepend' => '',
    'append' => ''
  ];

  static $email = [
    'default_value' => '',
    'placeholder' => '',
    'prepend' => '',
    'append' => ''
  ];

  static $url = [
    'default_value' => '',
    'placeholder' => ''
  ];

  static $password = [
    'placeholder' => '',
    'prepend' => '',
    'append' => '',
    'readonly' => 0,
    'disabled' => 0
  ];

  // Content
  //----------------------------------------------------------------------------------------------------------------------

  static $wysiwyg = [
    'tabs' => 'all',
    'toolbar' => 'full',
    'media_upload' => 1,
    'default_value' => '',
    'delay' => 0
  ];

  static $oembed = [
    'width' => '',
    'height' => ''
  ];

  static $image = [
    'return_format' => 'array',
    'preview_size' => 'thumbnail',
    'library' => 'all',
    'min_width' => 0,
    'min_height' => 0,
    'min_size' => 0,
    'max_width' => 0,
    'max_height' => 0,
    'max_size' => 0,
    'mime_types' => ''
  ];

  static $file = [
    'return_format' => 'array',
    'library' => 'all',
    'min_size' => 0,
    'max_size' => 0,
    'mime_types' => ''
  ];

  static $gallery = [
    'library' => 'all',
    'min' => 0,
    'max' => 0,
    'min_width' => 0,
    'min_height' => 0,
    'min_size' => 0,
    'max_width' => 0,
    'max_height' => 0,
    'max_size' => 0,
    'mime_types' => '',
    'insert' => 'append'
  ];

  // Choice
  //----------------------------------------------------------------------------------------------------------------------

  static $select = [
    'multiple' => 0,
    'allow_null' => 0,
    'choices' => [],
    'default_value' => '',
    'ui' => 0,
    'ajax' => 0,
    'placeholder' => '',
    'return_format' => 'value'
  ];

  static $checkbox = [
    'layout' => 'vertical',
    'choices' => [],
    'default_value' => '',
    'allow_custom' => 0,
    'save_custom' => 0,
    'toggle' => 0,
    'return_format' => 'value'
  ];

  static $radio = [
    'layout' => 'vertical',
    'choices' => [],
    'default_value' => '',
    'other_choice' => 0,
    'save_other_choice' => 0,
    'allow_null' => 0,
    'return_format' => 'value'
  ];

  static $true_false = [
    'default_value' => 0,
    'message' => '',
    'ui' => 0,
    'ui_on_text' => '',
    'ui_off_text' => ''
  ];

  // Relational
  //----------------------------------------------------------------------------------------------------------------------

  static $post_object = [
    'post_type' => [],
    'taxonomy' => [],
    'allow_null' => 0,
    'multiple' => 0,
    'return_format' => 'object',
    'ui' => 1
  ];

  static $page_link = [
    'post_type' => [],
    'taxonomy' => [],
    'allow_null' => 0,
    'multiple' => 0,
    'allow_archives' => 1
  ];

  static $relationship = [
    'post_type' => [],
    'taxonomy' => [],
    'min' => 0,
    'max' => 0,
    'filters' => ['search', 'post_type', 'taxonomy'],
    'elements' => [],
    'return_format' => 'object'
  ];

  static $taxonomy = [
    'taxonomy' => 'category',
    'field_type' => 'checkbox',
    'multiple' => 0,
    'allow_null' => 0,
    'return_format' => 'id',
    'add_term' => 1,
    'load_terms' => 0,
    'save_terms' => 0
  ];

  static $user = [
    'role' => '',
    'multiple' => 0,
    'allow_null' => 0
  ];

  // jQuery
  //----------------------------------------------------------------------------------------------------------------------

  static $google_map = [
    'height' => '',
    'center_lat' => '',
    'center_lng' => '',
    'zoom' => ''
  ];

  static $date_picker = [
    'display_format' => 'd/m/Y',
    'return_format' => 'd/m/Y',
    'first_day' => 1
  ];

  static $date_time_picker = [
    'display_format' => 'd/m/Y g:i a',
    'return_format' => 'd/m/Y g:i a',
    'first_day' => 1
  ];

  static $time_picker = [
    'display_format' => 'g:i a',
    'return_format' => 'g:i a'
  ];

  static $color_picker = [
    'default_value' => ''
  ];

  // Layout
  //----------------------------------------------------------------------------------------------------------------------

  static $message = [
    'message' => '',
    'esc_html' => 0,
    'new_lines' => 'wpautop'
  ];

  static $tab = [
    'placement' => 'top',
    'endpoint' => 0
  ];

  static $repeater = [
    'sub_fields' => [],
    'min' => 0,
    'max' => 0,
    'layout' => 'table',
    'button_label' => 'Add Row',
    'collapsed' => ''
  ];

  static $flexible_content = [
    'layouts' => [],
    'min' => 0,
    'max' => 0,
    'button_label' => 'Add Row'
  ];

  static $clone = [
    'clone' => '',
    'prefix_label' => 0,
    'prefix_name' => 0,
    'display' => 'seamless',
    'layout' => 'block'
  ];

}
