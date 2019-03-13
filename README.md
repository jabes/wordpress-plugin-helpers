![](logo.png)

---

A collection of helpers for use in WordPress development.

---

## Installation

To setup in a new project:

```
cd wp-content/mu-plugins
git init
git submodule add git@github.com:jabes/wp-tools.git
```

To setup from a cloned project:

```
git submodule update --init
```

Typical directory structure:

```
|- themes/
|- plugins/
|- mu-plugins/
   |- wp-tools/
      |- src/
      |- wp-tools.php
   |- my-plugin/
      |- src/
      |- my-plugin.php
   |- load.php
```

Where `load.php` might look like:

```
require_once 'wp-tools/wp-tools.php';
require_once 'my-plugin/my-plugin.php';
```

## Custom Fields

A layer on top of [ACF](http://www.advancedcustomfields.com/) to help programmatically create, update, and get custom field values.

#### Register

```
function register_custom_fields()
{
  CustomFields::register(
    'my_custom_fields', // id
    'My Custom Fields', // title
    // fields
    array(
      CustomFields::text_field('title', 'Title', array(
        'instructions' => 'This is a custom title.',
      )),
      CustomFields::textarea_field('description', 'Description', array(
        'instructions' => 'This is a custom description.',
        'maxlength' => 256,
        'rows' => 6,
      )),
      CustomFields::repeater_field('sub_fields', 'Sub Fields', array(
        CustomFields::text_field('sub_field_1', 'Sub Field 1'),
        CustomFields::text_field('sub_field_2', 'Sub Field 2'),
        CustomFields::text_field('sub_field_3', 'Sub Field 3'),
      )),
    ),
    // location
    array(
      array(
        array(
          'param' => 'page_template',
          'operator' => '==',
          'value' => 'default',
        )
      )
    ),
    // options
    array(
      'position' => 'normal',
      'layout' => 'default',
      'hide_on_screen' => CustomFields::$hide_all_on_screen,
    )
  );
}

add_action('init', 'register_custom_fields');
```

#### Update

Because the native [update_field](http://www.advancedcustomfields.com/resources/update_field/) method requires a field key you should use the `CustomFields::update_field` helper method which converts the provided field name into a field key.

```
$post = get_post();
CustomFields::update_field('name', 'value', $post->ID);
```

#### Get

You can use the native [get_field](http://www.advancedcustomfields.com/resources/get_field/) method to retrieve field values which accepts both a field name and field key.

```
$post = get_post();
get_field('name', $post->ID);
```

You may also use the provided `CustomFields::get_field` helper method which converts the provided field name into a field key.

```
$post = get_post();
CustomFields::get_field('name', $post->ID);
```

#### Remove Admin Menu

```
function remove_acf_menu()
{
  remove_menu_page('edit.php?post_type=acf');
}

add_action('admin_menu', 'remove_acf_menu', 999);
```

## Custom Post Types

A layer on top of the WordPress [register_post_type](https://codex.wordpress.org/Function_Reference/register_post_type) function to help simplify and normalize the process.

#### Register

```
function register_custom_post_types()
{
  PostTypes::register('my_custom_post_type', array(
    'single' => array(
      'lower' => 'my custom post type',
      'upper' => 'My Custom Post Type',
    ),
    'plural' => array(
      'lower' => 'my custom post types',
      'upper' => 'My Custom Post Types',
    ),
  ), array(
    // https://developer.wordpress.org/resource/dashicons/
    'menu_icon' => 'dashicons-admin-site',
  ));
}

add_action('init', 'register_custom_post_types');
```

## Taxonomy

A layer on top of the WordPress [register_taxonomy](https://codex.wordpress.org/Function_Reference/register_taxonomy) function to help simplify and normalize the process.

#### Register

```
function register_taxonomies()
{
  Taxonomy::register('my_taxonomy', 'my_custom_post_type', array(
    'single' => array('upper' => 'My Taxonomy'),
    'plural' => array('upper' => 'My Taxonomies'),
  ));
}

add_action('init', 'register_taxonomies');
```

#### Terms

While taxonomies must be constantly registered, taxonomy terms should only be inserted once or they duplicate.

```
function add_taxonomy_terms()
{
  $key = 'taxonomy_terms_added';
  $added = get_option($key);
  if (!$added) {
    Taxonomy::insert_terms('my_taxonomy', array(
      'Term 1',
      'Term 2',
      'Term 3',
    ));
    update_option($key, true);
  }
}

add_action('admin_init', 'add_taxonomy_terms');
```

#### Query Usage

```
$tax_query = array();
$tax_query[] = array(
  'taxonomy' => 'my_taxonomy',
  'field'    => 'slug',
  'operator' => 'IN',
  'terms'    => array(
    'term_1',
    'term_2',
    'term_3',
  ),
);

$args = array(
  'post_type'      => 'my_custom_post_type',
  'post_status'    => 'publish',
  'posts_per_page' => -1,
  'tax_query'      => $tax_query,
);

$query = WP_Query($args);
```

## Customizer

A layer on top of the WordPress [customize_register](https://codex.wordpress.org/Plugin_API/Action_Reference/customize_register) function to help simplify and normalize the process.

Example Usage:

```
function register_custom_options(WP_Customize_Manager $wp_customize)
{
  Customizer::add_section($wp_customize, 'my_customizer_section', array(
    'title' => "My Customizer Section",
  ));

  Customizer::add_setting($wp_customize, 'my_customizer_setting');
  Customizer::add_control($wp_customize, 'my_customizer_setting', array(
    'label' => "My Customizer Setting",
    'description' => "A description for this control.",
    'section' => 'my_customizer_section',
    'type' => 'text',
  ));
}

add_action('customize_register', 'register_custom_options');
```

## Admin Notice

A helper class that shows admin notices on page refresh.

Example Usage:

```
function validate_post_data($data, $postarr)
{
  $error = false;

  $post_type = $data['post_type'];
  if ($post_type != 'my_custom_post_type') return $data;

  if (empty($postarr['post_title'])) {
    Notice::error('Please provide a post title.');
    $error = true;
  }

  if ($error) {
    // Draft the post when there has been an error
    $data['post_status'] = 'draft';
    // The post message will now be outdated so refresh it
    add_filter('redirect_post_location', function ($location) {
      return add_query_arg('message', 10, $location);
    });
  }

  return $data;
}

add_action('wp_insert_post_data', 'validate_post_data', 99, 2);
```
