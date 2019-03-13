![WP Tools](banner.png)

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

## Fields

A layer on top of [ACF](http://www.advancedcustomfields.com/) to help programmatically create, update, and get custom field values.

#### Register Field Group

```php
<?php
function register_fields()
{
  $group = new FieldGroup('group_name', 'Group Name');
  $group->field('text', 'heading', 'Heading');
  $group->field('textarea', 'description', 'Description');
  $group->field('repeater', 'items', 'Items')
        ->sub_field('post_object', 'item', 'Item', [ 'post_type' => 'item' ])
        ->sub_field('true_false', 'is_visible', 'Visibility', [
          'default_value' => 1,
          'message' => 'Should we temporarily hide this?',
          'ui' => 1,
          'ui_on_text' => 'Visible',
          'ui_off_text' => 'Hidden',
        ]);
  $group->location('post_type', 'page');
  $group->options(['style' => 'seamless']);
  $group->register();
}

add_action('init', 'register_fields');
```

#### Get Field Value

```php
<?php
$post = get_post();
Field::get($post->ID,'group_name', 'heading');
Field::get($post->ID,'group_name', 'description');
Field::get($post->ID,'group_name', 'items');
```

#### Update Field Value

```php
<?php
$post = get_post();
Field::update($post->ID, 'group_name', 'heading', 'This is a heading');
Field::update($post->ID, 'group_name', 'description', 'The quick brown fox jumps over the lazy dog.');
Field::update_sub_field($post->ID, 'group_name', 'items', 'item', 0, 'First Item Value');
Field::update_sub_field($post->ID, 'group_name', 'items', 'item', 0, 'Second Item Value');
Field::update_sub_field($post->ID, 'group_name', 'items', 'item', 0, 'Third Item Value');
```

## Post Types

A layer on top of the WordPress [register_post_type](https://codex.wordpress.org/Function_Reference/register_post_type) function to help simplify and normalize the process.

#### Register

```php
<?php
function register_post_types()
{
  PostType::register('my_post_type', array(
    'single' => array(
      'lower' => 'my post type',
      'upper' => 'My Post Type',
    ),
    'plural' => array(
      'lower' => 'my post types',
      'upper' => 'My Post Types',
    ),
  ), array(
    'menu_icon' => 'dashicons-admin-site',
  ));
}

add_action('init', 'register_post_types');
```

## Taxonomy

A layer on top of the WordPress [register_taxonomy](https://codex.wordpress.org/Function_Reference/register_taxonomy) function to help simplify and normalize the process.

#### Register

```php
<?php
function register_taxonomies()
{
  Taxonomy::register('my_taxonomy', 'my_post_type', array(
    'single' => array('upper' => 'My Taxonomy'),
    'plural' => array('upper' => 'My Taxonomies'),
  ));
}

add_action('init', 'register_taxonomies');
```

#### Terms

While taxonomies must be constantly registered, taxonomy terms should only be inserted once or they duplicate.

```php
<?php
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

```php
<?php
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
  'post_type'      => 'my_post_type',
  'post_status'    => 'publish',
  'posts_per_page' => -1,
  'tax_query'      => $tax_query,
);

$query = WP_Query($args);
```

## Customizer

A layer on top of the WordPress [customize_register](https://codex.wordpress.org/Plugin_API/Action_Reference/customize_register) function to help simplify and normalize the process.

Example Usage:

```php
<?php
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

```php
<?php
function validate_post_data($data, $postarr)
{
  $error = false;

  $post_type = $data['post_type'];
  if ($post_type != 'my_post_type') return $data;

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
