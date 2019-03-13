<?php

class CustomFields
{

  static $field_keys = array();

  static $default_location = array(
    // rule group (or)
    array(
      // rule (and)
      array(
        // BASIC
        // post_type : Post Type
        // user_type: Logged in User Type
        // POST
        // post : Post
        // post_category : Post Category
        // post_format : Post Format
        // post_status : Post Status
        // taxonomy : Post Taxonomy
        // PAGE
        // page : Page
        // page_type : Page Type
        // page_parent : Page Parent
        // page_template : Page Template
        // OTHER
        // ef_media : Attachment
        // ef_taxonomy : Taxonomy Term
        // ef_user : User
        'param' => 'post_type',
        'operator' => '==',
        'value' => 'post',
        'order_no' => 0,
        'group_no' => 0,
      )
    )
  );

  static $default_options = array(
    // acf_after_title : High (after title)
    // normal : Normal (after content)
    // side : Side
    'position' => 'normal',
    // no_box: Seamless (no metabox)
    // default: Standard (WP metabox)
    'layout' => 'default',
    // permalink
    // the_content
    // excerpt
    // custom_fields
    // discussion
    // comments
    // revisions
    // slug
    // author
    // format
    // featured_image
    // categories
    // tags
    // send-trackbacks
    'hide_on_screen' => array(),
  );

  static $hide_all_on_screen = array(
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
  );

  static function register($id, $title, array $fields, array $location = null, array $options = null, $menu_order = 0)
  {
    if (!function_exists("register_field_group")) return;
    register_field_group(array(
      'id' => $id,
      'title' => $title,
      'menu_order' => $menu_order,
      'fields' => $fields,
      'location' => isset($location) ? $location : CustomFields::$default_location,
      'options' => isset($options) ? $options : CustomFields::$default_options,
    ));
  }

  static function get_field_key($name)
  {
    // Unique identifier for the field. Must begin with 'field_'
    $field_key = 'field_' . md5($name);
    CustomFields::$field_keys[$name] = $field_key;
    return $field_key;
  }

  static function get_field($name, $post_id = false, $format_value = true)
  {
    $field_key = CustomFields::get_field_key($name);
    // http://www.advancedcustomfields.com/resources/get_field/
    return get_field($field_key, $post_id, $format_value);
  }

  static function get_fields($post_id = false, $format_value = true)
  {
    // http://www.advancedcustomfields.com/resources/get_fields/
    return get_fields($post_id, $format_value);
  }

  static function update_field($name, $value, $post_id = false)
  {
    $field_key = CustomFields::get_field_key($name);
    // http://www.advancedcustomfields.com/resources/update_field/
    return update_field($field_key, $value, $post_id);
  }

  static function get_field_settings($type, $name, $label)
  {
    $field_key = array_key_exists($name, CustomFields::$field_keys)
      ? CustomFields::$field_keys[$name]
      : CustomFields::get_field_key($name);
    return array_merge(
      DefaultFieldSettings::$generic_field,
      array(
        'key' => $field_key,
        'type' => $type,
        'name' => $name,
        'label' => $label,
      )
    );
  }

  //
  // BASIC
  //

  static function text_field($name, $label, array $custom_field_settings = null)
  {
    $field_settings = CustomFields::get_field_settings('text', $name, $label);
    if (!$custom_field_settings) $custom_field_settings = array();
    return array_merge($field_settings, DefaultFieldSettings::$text_field, $custom_field_settings);
  }

  static function textarea_field($name, $label, array $custom_field_settings = null)
  {
    $field_settings = CustomFields::get_field_settings('textarea', $name, $label);
    if (!$custom_field_settings) $custom_field_settings = array();
    return array_merge($field_settings, DefaultFieldSettings::$textarea_field, $custom_field_settings);
  }

  static function number_field($name, $label, array $custom_field_settings = null)
  {
    $field_settings = CustomFields::get_field_settings('number', $name, $label);
    if (!$custom_field_settings) $custom_field_settings = array();
    return array_merge($field_settings, DefaultFieldSettings::$number_field, $custom_field_settings);
  }

  static function email_field($name, $label, array $custom_field_settings = null)
  {
    $field_settings = CustomFields::get_field_settings('email', $name, $label);
    if (!$custom_field_settings) $custom_field_settings = array();
    return array_merge($field_settings, DefaultFieldSettings::$email_field, $custom_field_settings);
  }

  static function password_field($name, $label, array $custom_field_settings = null)
  {
    $field_settings = CustomFields::get_field_settings('password', $name, $label);
    if (!$custom_field_settings) $custom_field_settings = array();
    return array_merge($field_settings, DefaultFieldSettings::$password_field, $custom_field_settings);
  }

  //
  // CONTENT
  //

  static function wysiwyg_field($name, $label, array $custom_field_settings = null)
  {
    $field_settings = CustomFields::get_field_settings('wysiwyg', $name, $label);
    if (!$custom_field_settings) $custom_field_settings = array();
    return array_merge($field_settings, DefaultFieldSettings::$wysiwyg_field, $custom_field_settings);
  }

  static function oembed_field($name, $label, array $custom_field_settings = null)
  {
    $field_settings = CustomFields::get_field_settings('oembed', $name, $label);
    if (!$custom_field_settings) $custom_field_settings = array();
    return array_merge($field_settings, DefaultFieldSettings::$oembed_field, $custom_field_settings);
  }

  static function image_field($name, $label, array $custom_field_settings = null)
  {
    $field_settings = CustomFields::get_field_settings('image', $name, $label);
    if (!$custom_field_settings) $custom_field_settings = array();
    return array_merge($field_settings, DefaultFieldSettings::$image_field, $custom_field_settings);
  }

  static function file_field($name, $label, array $custom_field_settings = null)
  {
    $field_settings = CustomFields::get_field_settings('file', $name, $label);
    if (!$custom_field_settings) $custom_field_settings = array();
    return array_merge($field_settings, DefaultFieldSettings::$file_field, $custom_field_settings);
  }

  static function gallery_field($name, $label, array $custom_field_settings = null)
  {
    $field_settings = CustomFields::get_field_settings('gallery', $name, $label);
    if (!$custom_field_settings) $custom_field_settings = array();
    return array_merge($field_settings, DefaultFieldSettings::$gallery_field, $custom_field_settings);
  }

  //
  // CHOICE
  //

  static function select_field($name, $label, array $custom_field_settings = null)
  {
    $field_settings = CustomFields::get_field_settings('select', $name, $label);
    if (!$custom_field_settings) $custom_field_settings = array();
    return array_merge($field_settings, DefaultFieldSettings::$select_field, $custom_field_settings);
  }

  static function checkbox_field($name, $label, array $custom_field_settings = null)
  {
    $field_settings = CustomFields::get_field_settings('checkbox', $name, $label);
    if (!$custom_field_settings) $custom_field_settings = array();
    return array_merge($field_settings, DefaultFieldSettings::$checkbox_field, $custom_field_settings);
  }

  static function radio_field($name, $label, array $custom_field_settings = null)
  {
    $field_settings = CustomFields::get_field_settings('radio', $name, $label);
    if (!$custom_field_settings) $custom_field_settings = array();
    return array_merge($field_settings, DefaultFieldSettings::$radio_field, $custom_field_settings);
  }

  static function true_false_field($name, $label, array $custom_field_settings = null)
  {
    $field_settings = CustomFields::get_field_settings('true_false', $name, $label);
    if (!$custom_field_settings) $custom_field_settings = array();
    return array_merge($field_settings, DefaultFieldSettings::$true_false_field, $custom_field_settings);
  }

  //
  // RELATIONAL
  //

  static function post_object_field($name, $label, array $custom_field_settings = null)
  {
    $field_settings = CustomFields::get_field_settings('post_object', $name, $label);
    if (!$custom_field_settings) $custom_field_settings = array();
    return array_merge($field_settings, DefaultFieldSettings::$post_object_field, $custom_field_settings);
  }

  static function page_link_field($name, $label, array $custom_field_settings = null)
  {
    $field_settings = CustomFields::get_field_settings('page_link', $name, $label);
    if (!$custom_field_settings) $custom_field_settings = array();
    return array_merge($field_settings, DefaultFieldSettings::$page_link_field, $custom_field_settings);
  }

  static function relationship_field($name, $label, array $custom_field_settings = null)
  {
    $field_settings = CustomFields::get_field_settings('relationship', $name, $label);
    if (!$custom_field_settings) $custom_field_settings = array();
    return array_merge($field_settings, DefaultFieldSettings::$relationship_field, $custom_field_settings);
  }

  static function taxonomy_field($name, $label, array $custom_field_settings = null)
  {
    $field_settings = CustomFields::get_field_settings('taxonomy', $name, $label);
    if (!$custom_field_settings) $custom_field_settings = array();
    return array_merge($field_settings, DefaultFieldSettings::$taxonomy_field, $custom_field_settings);
  }

  static function user_field($name, $label, array $custom_field_settings = null)
  {
    $field_settings = CustomFields::get_field_settings('user', $name, $label);
    if (!$custom_field_settings) $custom_field_settings = array();
    return array_merge($field_settings, DefaultFieldSettings::$user_field, $custom_field_settings);
  }

  //
  // JQUERY
  //

  static function color_picker_field($name, $label, array $custom_field_settings = null)
  {
    $field_settings = CustomFields::get_field_settings('color_picker', $name, $label);
    if (!$custom_field_settings) $custom_field_settings = array();
    return array_merge($field_settings, DefaultFieldSettings::$color_picker_field, $custom_field_settings);
  }

  //
  // LAYOUT
  //

  static function flexible_content_field($name, $label, array $custom_field_settings = null)
  {
    $field_settings = CustomFields::get_field_settings('flexible_content', $name, $label);
    if (!$custom_field_settings) $custom_field_settings = array();
    return array_merge($field_settings, DefaultFieldSettings::$flexible_content_field, $custom_field_settings);
  }

  static function repeater_field($name, $label, array $custom_field_settings = null)
  {
    $field_settings = CustomFields::get_field_settings('repeater', $name, $label);
    if (!$custom_field_settings) $custom_field_settings = array();
    return array_merge($field_settings, DefaultFieldSettings::$repeater_field, $custom_field_settings);
  }

}

/**
 * @see http://www.advancedcustomfields.com/resources/register-fields-via-php/
 */
class DefaultFieldSettings
{

  static $generic_field = array(

    /* (string) Unique identifier for the field. Must begin with 'field_' */
    'key' => 'field_1',

    /* (string) Visible when editing the field value */
    'label' => 'Sub Title',

    /* (string) Used to save and load data. Single word, no spaces. Underscores and dashes allowed */
    'name' => 'sub_title',

    /* (string) Type of field (text, textarea, image, etc) */
    'type' => 'text',

    /* (string) Instructions for authors. Shown when submitting data */
    'instructions' => '',

    /* (int) Whether or not the field value is required. Defaults to 0 */
    'required' => 0,

    /* (mixed) Conditionally hide or show this field based on other field's values.
    Best to use the ACF UI and export to understand the array structure. Defaults to 0 */
    'conditional_logic' => 0,

    /* (array) An array of attributes given to the field element */
    'wrapper' => array(
      'width' => '',
      'class' => '',
      'id' => '',
    ),

    /* (mixed) A default value used by ACF if no value has yet been saved */
    'default_value' => '',

  );

  // Basic
  //----------------------------------------------------------------------------------------------------------------------

  static $text_field = array(

    /* ... Insert generic settings here ... */

    /* (string) Appears within the input. Defaults to '' */
    'placeholder' => '',

    /* (string) Appears before the input. Defaults to '' */
    'prepend' => '',

    /* (string) Appears after the input. Defaults to '' */
    'append' => '',

    /* (string) Restricts the character limit. Defaults to '' */
    'maxlength' => '',

    /* (bool) Makes the input readonly. Defaults to 0 */
    'readonly' => 0,

    /* (bool) Makes the input disabled. Defaults to 0 */
    'disabled' => 0,

  );

  static $textarea_field = array(

    /* ... Insert generic settings here ... */

    /* (string) Appears within the input. Defaults to '' */
    'placeholder' => '',

    /* (string) Restricts the character limit. Defaults to '' */
    'maxlength' => '',

    /* (int) Restricts the number of rows and height. Defaults to '' */
    'rows' => '',

    /* (new_lines) Decides how to render new lines. Detauls to 'wpautop'.
    Choices of 'wpautop' (Automatically add paragraphs), 'br' (Automatically add <br>) or '' (No Formatting) */
    'new_lines' => '',

    /* (bool) Makes the input readonly. Defaults to 0 */
    'readonly' => 0,

    /* (bool) Makes the input disabled. Defaults to 0 */
    'disabled' => 0,

  );

  static $number_field = array(

    /* ... Insert generic settings here ... */

    /* (string) Appears within the input. Defaults to '' */
    'placeholder' => '',

    /* (string) Appears before the input. Defaults to '' */
    'prepend' => '',

    /* (string) Appears after the input. Defaults to '' */
    'append' => '',

    /* (int) Minimum number value. Defaults to '' */
    'min' => '',

    /* (int) Maximum number value. Defaults to '' */
    'max' => '',

    /* (int) Step size increments. Defaults to '' */
    'step' => '',

  );

  static $email_field = array(

    /* ... Insert generic settings here ... */

    /* (string) Appears within the input. Defaults to '' */
    'placeholder' => '',

    /* (string) Appears before the input. Defaults to '' */
    'prepend' => '',

    /* (string) Appears after the input. Defaults to '' */
    'append' => '',

  );

  static $password_field = array(

    /* ... Insert generic settings here ... */

    /* (string) Appears within the input. Defaults to '' */
    'placeholder' => '',

    /* (string) Appears before the input. Defaults to '' */
    'prepend' => '',

    /* (string) Appears after the input. Defaults to '' */
    'append' => '',

  );

  // Content
  //----------------------------------------------------------------------------------------------------------------------

  static $wysiwyg_field = array(

    /* ... Insert generic settings here ... */

    /* (string) Specify which tabs are available. Defaults to 'all'.
    Choices of 'all' (Visual & Text), 'visual' (Visual Only) or text (Text Only) */
    'tabs' => 'all',

    /* (string) Specify the editor's toolbar. Defaults to 'full'.
    Choices of 'full' (Full), 'basic' (Basic) or a custom toolbar (http://www.advancedcustomfields.com/resources/customize-the-wysiwyg-toolbars/) */
    'toolbar' => 'full',

    /* (bool) Show the media upload button. Defaults to 1 */
    'media_upload' => 1,

  );

  static $oembed_field = array(

    /* ... Insert generic settings here ... */

    /* (int) Specify the width of the oEmbed element. Can be overridden by CSS */
    'width' => '',

    /* (int) Specify the height of the oEmbed element. Can be overridden by CSS */
    'height' => '',

  );

  static $image_field = array(

    /* ... Insert generic settings here ... */

    /* (string) Specify the type of value returned by get_field(). Defaults to 'array'.
    Choices of 'array' (Image Array), 'url' (Image URL) or 'id' (Image ID) */
    'return_format' => 'array',

    /* (string) Specify the image size shown when editing. Defaults to 'thumbnail'. */
    'preview_size' => 'thumbnail',

    /* (string) Restrict the image library. Defaults to 'all'.
    Choices of 'all' (All Images) or 'uploadedTo' (Uploaded to post) */
    'library' => 'all',

    /* (int) Specify the minimum width in px required when uploading. Defaults to 0 */
    'min_width' => 0,

    /* (int) Specify the minimum height in px required when uploading. Defaults to 0 */
    'min_height' => 0,

    /* (int) Specify the minimum filesize in MB required when uploading. Defaults to 0
    The unit may also be included. eg. '256KB' */
    'min_size' => 0,

    /* (int) Specify the maximum width in px allowed when uploading. Defaults to 0 */
    'max_width' => 0,

    /* (int) Specify the maximum height in px allowed when uploading. Defaults to 0 */
    'max_height' => 0,

    /* (int) Specify the maximum filesize in MB in px allowed when uploading. Defaults to 0
    The unit may also be included. eg. '256KB' */
    'max_size' => 0,

    /* (string) Comma separated list of file type extensions allowed when uploading. Defaults to '' */
    'mime_types' => '',

  );

  static $file_field = array(

    /* ... Insert generic settings here ... */

    /* (string) Specify the type of value returned by get_field(). Defaults to 'array'.
    Choices of 'array' (File Array), 'url' (File URL) or 'id' (File ID) */
    'return_format' => 'array',

    /* (string) Specify the file size shown when editing. Defaults to 'thumbnail'. */
    'preview_size' => 'thumbnail',

    /* (string) Restrict the file library. Defaults to 'all'.
    Choices of 'all' (All Files) or 'uploadedTo' (Uploaded to post) */
    'library' => 'all',

    /* (int) Specify the minimum filesize in MB required when uploading. Defaults to 0
    The unit may also be included. eg. '256KB' */
    'min_size' => 0,

    /* (int) Specify the maximum filesize in MB in px allowed when uploading. Defaults to 0
    The unit may also be included. eg. '256KB' */
    'max_size' => 0,

    /* (string) Comma separated list of file type extensions allowed when uploading. Defaults to '' */
    'mime_types' => '',

  );

  static $gallery_field = array(

    /* ... Insert generic settings here ... */

    /* (int) Specify the minimum attachments required to be selected. Defaults to 0 */
    'min' => 0,

    /* (int) Specify the maximum attachments allowed to be selected. Defaults to 0 */
    'max' => 0,

    /* (string) Specify the image size shown when editing. Defaults to 'thumbnail'. */
    'preview_size' => 'thumbnail',

    /* (string) Restrict the image library. Defaults to 'all'.
    Choices of 'all' (All Images) or 'uploadedTo' (Uploaded to post) */
    'library' => 'all',

    /* (int) Specify the minimum width in px required when uploading. Defaults to 0 */
    'min_width' => 0,

    /* (int) Specify the minimum height in px required when uploading. Defaults to 0 */
    'min_height' => 0,

    /* (int) Specify the minimum filesize in MB required when uploading. Defaults to 0
    The unit may also be included. eg. '256KB' */
    'min_size' => 0,

    /* (int) Specify the maximum width in px allowed when uploading. Defaults to 0 */
    'max_width' => 0,

    /* (int) Specify the maximum height in px allowed when uploading. Defaults to 0 */
    'max_height' => 0,

    /* (int) Specify the maximum filesize in MB in px allowed when uploading. Defaults to 0
    The unit may also be included. eg. '256KB' */
    'max_size' => 0,

    /* (string) Comma separated list of file type extensions allowed when uploading. Defaults to '' */
    'mime_types' => '',

  );

  // Choice
  //----------------------------------------------------------------------------------------------------------------------

  static $select_field = array(

    /* ... Insert generic settings here ... */

    /* (array) Array of choices where the key ('red') is used as value and the value ('Red') is used as label */
    'choices' => array(
      'red' => 'Red'
    ),

    /* (bool) Allow a null (blank) value to be selected. Defaults to 0 */
    'allow_null' => 0,

    /* (bool) Allow mulitple choices to be selected. Defaults to 0 */
    'multiple' => 0,

    /* (bool) Use the select2 interfacte. Defaults to 0 */
    'ui' => 0,

    /* (bool) Load choices via AJAX. The ui setting must also be true for this to work. Defaults to 0 */
    'ajax' => 0,

    /* (string) Appears within the select2 input. Defaults to '' */
    'placeholder' => '',

  );

  static $checkbox_field = array(

    /* ... Insert generic settings here ... */

    /* (array) Array of choices where the key ('red') is used as value and the value ('Red') is used as label */
    'choices' => array(
      'red' => 'Red'
    ),

    /* (string) Specify the layout of the checkbox inputs. Defaults to 'vertical'.
    Choices of 'vertical' or 'horizontal' */
    'layout' => 0,

  );

  static $radio_field = array(

    /* ... Insert generic settings here ... */

    /* (array) Array of choices where the key ('red') is used as value and the value ('Red') is used as label */
    'choices' => array(
      'red' => 'Red'
    ),

    /* (bool) Allow a custom choice to be entered via a text input */
    'other_choice' => 0,

    /* (bool) Allow the custom value to be added to this field's choices. Defaults to 0.
    Will not work with PHP registered fields, only DB fields */
    'save_other_choice' => 0,

    /* (string) Specify the layout of the checkbox inputs. Defaults to 'vertical'.
    Choices of 'vertical' or 'horizontal' */
    'layout' => 0,

  );

  static $true_false_field = array(

    /* ... Insert generic settings here ... */

    /* (string) Text shown along side the checkbox */
    'message' => 0,

  );

  // Relational
  //----------------------------------------------------------------------------------------------------------------------

  static $post_object_field = array(

    /* ... Insert generic settings here ... */

    /* (mixed) Specify an array of post types to filter the available choices. Defaults to '' */
    'post_type' => '',

    /* (mixed) Specify an array of taxonomies to filter the available choices. Defaults to '' */
    'taxonomy' => '',

    /* (bool) Allow a null (blank) value to be selected. Defaults to 0 */
    'allow_null' => 0,

    /* (bool) Allow mulitple choices to be selected. Defaults to 0 */
    'multiple' => 0,

    /* (string) Specify the type of value returned by get_field(). Defaults to 'object'.
    Choices of 'object' (Post object) or 'id' (Post ID) */
    'return_format' => 'object',

  );

  static $page_link_field = array(

    /* ... Insert generic settings here ... */

    /* (mixed) Specify an array of post types to filter the available choices. Defaults to '' */
    'post_type' => '',

    /* (mixed) Specify an array of taxonomies to filter the available choices. Defaults to '' */
    'taxonomy' => '',

    /* (bool) Allow a null (blank) value to be selected. Defaults to 0 */
    'allow_null' => 0,

    /* (bool) Allow mulitple choices to be selected. Defaults to 0 */
    'multiple' => 0,

  );

  static $relationship_field = array(

    /* ... Insert generic settings here ... */

    /* (mixed) Specify an array of post types to filter the available choices. Defaults to '' */
    'post_type' => '',

    /* (mixed) Specify an array of taxonomies to filter the available choices. Defaults to '' */
    'taxonomy' => '',

    /* (array) Specify the available filters used to search for posts.
    Choices of 'search' (Search input), 'post_type' (Post type select) and 'taxonomy' (Taxonomy select) */
    'filters' => array('search', 'post_type', 'taxonomy'),

    /* (array) Specify the visual elements for each post.
    Choices of 'featured_image' (Featured image icon) */
    'elements' => array(),

    /* (int) Specify the minimum posts required to be selected. Defaults to 0 */
    'min' => 0,

    /* (int) Specify the maximum posts allowed to be selected. Defaults to 0 */
    'max' => 0,

    /* (string) Specify the type of value returned by get_field(). Defaults to 'object'.
    Choices of 'object' (Post object) or 'id' (Post ID) */
    'return_format' => 'object',

  );

  static $taxonomy_field = array(

    /* ... Insert generic settings here ... */

    /* (string) Specify the taxonomy to select terms from. Defaults to 'category' */
    'taxonomy' => '',

    /* (array) Specify the appearance of the taxonomy field. Defaults to 'checkbox'
    Choices of 'checkbox' (Checkbox inputs), 'multi_select' (Select field - multiple), 'radio' (Radio inputs) or 'select' (Select field) */
    'field_type' => 'checkbox',

    /* (bool) Allow a null (blank) value to be selected. Defaults to 0 */
    'allow_null' => 0,

    /* (bool) Allow selected terms to be saved as relatinoships to the post */
    'load_save_terms' => 0,

    /* (string) Specify the type of value returned by get_field(). Defaults to 'id'.
    Choices of 'object' (Term object) or 'id' (Term ID) */
    'return_format' => 'id',

    /* (bool) Allow new terms to be added via a popup window */
    'add_term' => 1,

  );

  static $user_field = array(

    /* ... Insert generic settings here ... */

    /* (array) Array of roles to limit the users available for selection */
    'role' => array(),

    /* (bool) Allow a null (blank) value to be selected. Defaults to 0 */
    'allow_null' => 0,

    /* (bool) Allow mulitple choices to be selected. Defaults to 0 */
    'multiple' => 0,

  );

  // jQuery
  //----------------------------------------------------------------------------------------------------------------------

  static $color_picker_field = array(

    /* ... Insert generic settings here ... */

    'default_value' => '',

  );

  // Layout
  //----------------------------------------------------------------------------------------------------------------------

  static $flexible_content_field = array(

    /* ... Insert generic settings here ... */

    'layouts' => array(),
    'min' => '',
    'max' => '',
    'button_label' => "Add Row",

  );

  static $repeater_field = array(

    /* ... Insert generic settings here ... */

    'sub_fields' => array(),
    'row_min' => 0,
    'row_limit' => 0,
    'layout' => 'row',
    'button_label' => 'Add Row',

  );

}
