<?php

class Field
{

  public $key;
  public $group;
  public $type;
  public $name;
  public $label;
  public $settings;

  function __construct(FieldGroup $group, $type, $name, $label, array $custom_settings = [])
  {
    $this->group = $group;
    $this->type = $type;
    $this->label = $label;
    $this->name = Field::name($group->name, $name);
    $this->key = Field::key($group->name, $name);
    $this->settings = $this->settings($custom_settings);
  }

  static function name($group_name, $field_name)
  {
    return sprintf('%s_%s', $group_name, $field_name);
  }

  static function key($group_name, $field_name)
  {
    return sprintf(
      'field_%s',
      md5($group_name . $field_name)
    );
  }

  function settings(array $custom_settings = [])
  {
    return array_merge(
      FieldSettings::$generic,
      FieldSettings::${$this->type},
      [
        'key'   => $this->key,
        'type'  => $this->type,
        'name'  => $this->name,
        'label' => $this->label,
      ],
      $custom_settings
    );
  }

  /**
   * Adds a new sub field to a repeater or flexible content field
   *
   * @param string $type the type of field
   * @param string $name the field name
   * @param string $label the field label
   * @param array $custom_settings these settings will override the defaults
   * @return Field
   */
  function sub_field($type, $name, $label, array $custom_settings = [])
  {
    $field = new Field($this->group, $type, $name, $label, $custom_settings);
    $this->group->fields[$this->key]['sub_fields'][] = $field->settings;
    return $this;
  }

  /**
   * This function will return a custom field value for a specific field name/key + post_id.
   * There is a 3rd parameter to turn on/off formatting. This means that an Image field will not use
   * its 'return option' to format the value but return only what was saved in the database
   *
   * @param int $post_id the post_id of which the value is saved against
   * @param string $group_name the group name
   * @param string $field_name the field name
   * @param boolean $format_value whether or not to format the value as described above
   * @return mixed
   */
  static function get($post_id, $group_name, $field_name, $format_value = true)
  {
    return get_field(
      Field::name($group_name, $field_name),
      $post_id,
      $format_value
    );
  }

  /**
   * This function will return an array containing all the custom field values for a specific post_id.
   * The function is not very elegant and wastes a lot of PHP memory / SQL queries if you are not using all the values.
   *
   * @param int $post_id the post_id of which the value is saved against
   * @param boolean $format_value whether or not to format the field value
   * @return array associative array where field name => field value
   */
  static function all($post_id, $format_value = true)
  {
    return get_fields(
      $post_id,
      $format_value
    );
  }

  /**
   * This function will update a value in the database
   *
   * @param int $post_id the post_id of which the value is saved against
   * @param string $group_name the group name
   * @param string $field_name the field name
   * @param mixed $value the value to save in the database
   * @return boolean true on successful update, false on failure
   */
  static function update($post_id, $group_name, $field_name, $value)
  {
    return update_field(
      Field::name($group_name, $field_name),
      $value,
      $post_id
    );
  }

  /**
   * This function will remove a value from the database
   *
   * @param int $post_id the post_id of which the value is saved against
   * @param string $group_name the group name
   * @param string $field_name the field name
   * @return boolean true on successful delete, false on failure
   */
  static function delete($post_id, $group_name, $field_name)
  {
    return delete_field(
      Field::name($group_name, $field_name),
      $post_id
    );
  }

  static function add_row($post_id, $group_name, $field_name, array $values)
  {
    $row = [];
    foreach($values as $key => $value) {
      $row[ Field::name($group_name, $key) ] = $value;
    }

    return add_row(
      Field::name($group_name, $field_name),
      $row,
      $post_id
    );
  }

  static function update_row($post_id, $group_name, $field_name, $row_number, array $values)
  {
    $row = [];
    foreach($values as $key => $value) {
      $row[ Field::name($group_name, $key) ] = $value;
    }

    return update_row(
      Field::name($group_name, $field_name),
      $row_number,
      $row,
      $post_id
    );
  }

  static function delete_row($post_id, $group_name, $field_name, $row_number)
  {
    return delete_row(
      Field::name($group_name, $field_name),
      $row_number,
      $post_id
    );
  }

  static function update_sub_field($post_id, $group_name, $field_name, $sub_field_name, $row_number, $value)
  {
    return update_sub_field(
      [
        Field::name($group_name, $field_name),
        $row_number,
        Field::name($group_name, $sub_field_name),
      ],
      $value,
      $post_id
    );
  }

}
