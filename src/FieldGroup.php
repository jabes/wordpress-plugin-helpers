<?php

class FieldGroup
{

  public $key;
  public $name;
  public $title;
  public $fields;
  public $location;
  public $options;

  private $styles = [
    'default'  => 'default', // Standard (WP metabox)
    'seamless' => 'seamless', // Seamless (no metabox)
  ];

  private $positions = [
    'acf_after_title' => 'acf_after_title', // High (after title)
    'normal'          => 'normal', // Normal (after content)
    'side'            => 'side', // Side
  ];

  private $label_placements = [
    'top'  => 'top', // (Above fields)
    'left' => 'left', // (Beside fields)
  ];

  private $instruction_placements = [
    'label' => 'label', // (Below labels)
    'field' => 'field', // (Below fields)
  ];

  // Create a set of rules to determine which edit screens will use these advanced custom fields
  private $rule_types = [
    // Basic
    'post_type'     => 'post_type',
    'user_type'     => 'user_type',
    // Page
    'page'          => 'page',
    'page_type'     => 'page_type',
    'page_parent'   => 'page_parent',
    'page_template' => 'page_template',
    // Post
    'post'          => 'post',
    'post_category' => 'post_category',
    'post_format'   => 'post_format',
    'post_status'   => 'post_status',
    'taxonomy'      => 'taxonomy',
    // Other
    'ef_taxonomy'   => 'ef_taxonomy',
    'ef_user'       => 'ef_user',
    'ef_media'      => 'ef_media',
  ];

  // Items to hide from the edit screen.
  // If multiple field groups appear on an edit screen,
  // the first field group's options will be used.
  // (the one with the lowest order number)
  private $screen_options = [
    'permalink',
    'the_content',
    'excerpt',
    'custom_fields',
    'discussion',
    'comments',
    'revisions',
    'slug',
    'author',
    'format',
    'featured_image',
    'categories',
    'tags',
    'send-trackbacks',
  ];

  function __construct($name, $title)
  {
    $this->name = $name;
    $this->title = $title;
    $this->fields = [];
    $this->default_location();
    $this->default_options();
  }

  function show_on_screen(array $features_to_show)
  {
    $features_to_hide = $this->screen_options;
    return array_diff(
      $features_to_hide,
      $features_to_show
    );
  }

  function default_location()
  {
    $this->location('post_type', 'post');
  }

  function default_options()
  {
    $this->options = [

      // (string) Unique identifier for field group. Must begin with 'group_'.
      'key'                   => '',

      // (string) Visible in metabox handle.
      'title'                 => '',

      // (array) An array of fields.
      'fields'                => [],

      // (array) An array containing 'rule groups' where each 'rule group' is an array containing 'rules'.
      // Each group is considered an 'or', and each rule is considered an 'and'.
      'location'              => [],

      // (int) Field groups are shown in order from lowest to highest.
      'menu_order'            => 0,

      // (string) Determines the position on the edit screen. Defaults to normal.
      'position'              => $this->positions['normal'],

      // (string) Determines the metabox style.
      'style'                 => $this->styles['default'],

      // (string) Determines where field labels are places in relation to fields.
      'label_placement'       => $this->label_placements['top'],

      // (string) Determines where field instructions are places in relation to fields.
      'instruction_placement' => $this->instruction_placements['label'],

      // (array) An array of elements to hide on the screen.
      'hide_on_screen'        => $this->show_on_screen([
        'permalink',
        'the_content',
      ]),

    ];
  }

  /**
   * Sets the field group location
   * This will add a single location rule to a single rule group
   * It is intended as a convenience option and does not allow for multiple rules or rule groups
   *
   * @param $rule_type
   * @param $rule_value
   * @param string $operator
   * @param int $order_no
   * @param int $group_no
   */
  function location($rule_type, $rule_value, $operator = '==', $order_no = 0, $group_no = 0)
  {
    $rule = [
      'param'    => $this->rule_types[$rule_type],
      'operator' => $operator,
      'value'    => $rule_value,
      'order_no' => $order_no,
      'group_no' => $group_no,
    ];
    $rule_group = [$rule];
    $this->location = [$rule_group];
  }

  /**
   * Sets the field group options
   *
   * @param array $custom_options these options will override the defaults
   */
  function options(array $custom_options = [])
  {
    if (isset($custom_options['show_on_screen'])) {
      $custom_options['hide_on_screen'] = $this->show_on_screen($custom_options['show_on_screen']);
      unset($custom_options['show_on_screen']);
    }
    $this->options = array_merge($this->options, $custom_options);
  }

  /**
   * Adds a field to this group
   *
   * @param string $type the type of field
   * @param string $name the field name
   * @param string $label the field label
   * @param array $custom_settings these settings will override the defaults
   * @return Field
   */
  function field($type, $name, $label, array $custom_settings = [])
  {
    $field = new Field($this, $type, $name, $label, $custom_settings);
    $this->fields[$field->key] = $field->settings;
    return $field;
  }

  /**
   * Adds the field group to the local placeholder
   */
  function register()
  {
    $field_group = array_merge(
      $this->options,
      [
        'key'      => $this->key,
        'title'    => $this->title,
        'fields'   => $this->fields,
        'location' => $this->location,
      ]
    );
    acf_add_local_field_group($field_group);
  }

}
