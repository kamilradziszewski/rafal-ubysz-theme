<?php

if ( ! class_exists( 'Timber' ) ) {
  add_action( 'admin_notices', function() {
    echo '<div class="error"><p>Timber not activated. Make sure you activate the plugin in <a href="' . esc_url( admin_url( 'plugins.php#timber' ) ) . '">' . esc_url( admin_url( 'plugins.php') ) . '</a></p></div>';
  });
  
  add_filter('template_include', function($template) {
    return get_stylesheet_directory() . '/static/no-timber.html';
  });
  
  return;
}

Timber::$dirname = array('templates', 'views');

class StarterSite extends TimberSite {

  function __construct() {
    add_theme_support( 'post-formats' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'menus' );
    add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' ) );
    add_filter( 'timber_context', array( $this, 'add_to_context' ) );
    add_filter( 'get_twig', array( $this, 'add_to_twig' ) );
    add_action( 'init', array( $this, 'register_post_types' ) );
    add_action( 'init', array( $this, 'register_taxonomies' ) );
    parent::__construct();
  }

  function register_post_types() {
    //this is where you can register custom post types
  }

  function register_taxonomies() {
    //this is where you can register custom taxonomies
  }

  function add_to_context( $context ) {
    $context['foo'] = 'bar';
    $context['stuff'] = 'I am a value set in your functions.php file';
    $context['notes'] = 'These values are available everytime you call Timber::get_context();';
    $context['menu'] = new TimberMenu();
    $context['site'] = $this;

    $args = array(
    'post_type' => 'addresses',
    'order' => 'ASC',
    'orderby' => 'menu_order'
    );
    $context['addresses'] = Timber::get_posts( $args );
    
    return $context;
  }

  function myfoo( $text ) {
    $text .= ' bar!';
    return $text;
  }

  function add_to_twig( $twig ) {
    /* this is where you can add your own functions to twig */
    $twig->addExtension( new Twig_Extension_StringLoader() );
    $twig->addFilter('myfoo', new Twig_SimpleFilter('myfoo', array($this, 'myfoo')));
    return $twig;
  }

}

new StarterSite();





/*******************************************************************************
 * Enqueue scripts and styles
 */
function rafal_ubysz_scripts_and_styles() {
  wp_enqueue_style( 'rafal-ubysz-main', get_stylesheet_directory_uri() . '/static/dist/css/main.css' );

  wp_enqueue_script(	'googleapis',
                      'https://maps.googleapis.com/maps/api/js?key=AIzaSyDuvAWwm23t9fAC-8iYUwd5Enb60ALjfS0',
                      false,
                      false,
                      true );

  wp_enqueue_script(	'main-js',
                      get_stylesheet_directory_uri() . '/static/dist/js/main.min.js',
                      array('jquery'),
                      false,
                      true );
}
add_action( 'wp_enqueue_scripts', 'rafal_ubysz_scripts_and_styles' );



/*******************************************************************************
 * Register Google API Key
 */
function my_acf_google_map_api( $api ){
  $api['key'] = 'AIzaSyDuvAWwm23t9fAC-8iYUwd5Enb60ALjfS0';
  return $api;
}
add_filter('acf/fields/google_map/api', 'my_acf_google_map_api');



/*******************************************************************************
 * Include Advanced Custom Fields in the Theme
 */
define( 'ACF_LITE', true );
include_once('advanced-custom-fields/acf.php');

if(function_exists("register_field_group"))
{
  register_field_group(array (
    'id' => 'acf_addresses',
    'title' => 'Addresses',
    'fields' => array (
      array (
        'key' => 'field_5a857bc6b32c6',
        'label' => 'Info',
        'name' => '',
        'type' => 'tab',
      ),
      array (
        'key' => 'field_5a857ebdfc944',
        'label' => 'Instructions',
        'name' => '',
        'type' => 'message',
        'message' => 'Fields with * are required.',
      ),
      array (
        'key' => 'field_5a8573ada44e1',
        'label' => 'Additional Info',
        'name' => 'additional_info',
        'type' => 'text',
        'default_value' => '',
        'placeholder' => 'Zakład Radiologii',
        'prepend' => '',
        'append' => '',
        'formatting' => 'none',
        'maxlength' => '',
      ),
      array (
        'key' => 'field_5a857d6fe229e',
        'label' => 'Street',
        'name' => 'street',
        'type' => 'text',
        'required' => 1,
        'default_value' => '',
        'placeholder' => 'Marszałkowska 10',
        'prepend' => '',
        'append' => '',
        'formatting' => 'none',
        'maxlength' => '',
      ),
      array (
        'key' => 'field_5a857d92e229f',
        'label' => 'Telephone #1',
        'name' => 'telephone_1',
        'type' => 'text',
        'default_value' => '',
        'placeholder' => '22 33 44 555',
        'prepend' => '',
        'append' => '',
        'formatting' => 'none',
        'maxlength' => '',
      ),
      array (
        'key' => 'field_5a857de6e22a0',
        'label' => 'Telephone #2',
        'name' => 'telephone_2',
        'type' => 'text',
        'default_value' => '',
        'placeholder' => '0 123 456 789',
        'prepend' => '',
        'append' => '',
        'formatting' => 'none',
        'maxlength' => '',
      ),
      array (
        'key' => 'field_5a857e10e22a1',
        'label' => 'Webpage',
        'name' => 'webpage',
        'type' => 'text',
        'default_value' => '',
        'placeholder' => 'https://www.szpital.pl',
        'prepend' => '',
        'append' => '',
        'formatting' => 'none',
        'maxlength' => '',
      ),
      array (
        'key' => 'field_5a85805139b84',
        'label' => 'Opening Hours 1',
        'name' => 'opening_hours_1',
        'type' => 'text',
        'default_value' => '',
        'placeholder' => 'PN-PT 09:30-14:00',
        'prepend' => '',
        'append' => '',
        'formatting' => 'none',
        'maxlength' => '',
      ),
      array (
        'key' => 'field_5a8580b739b86',
        'label' => 'Opening Hours 2',
        'name' => 'opening_hours_2',
        'type' => 'text',
        'default_value' => '',
        'placeholder' => 'CZW 17:00-19:00',
        'prepend' => '',
        'append' => '',
        'formatting' => 'none',
        'maxlength' => '',
      ),
      array (
        'key' => 'field_5a857bddb32c7',
        'label' => 'Map',
        'name' => '',
        'type' => 'tab',
      ),
      array (
        'key' => 'field_5a857bf3b32c8',
        'label' => 'Map',
        'name' => 'map',
        'type' => 'google_map',
        'required' => 1,
        'center_lat' => '52.231838',
        'center_lng' => '21.0038063',
        'zoom' => 15,
        'height' => '',
      ),
    ),
    'location' => array (
      array (
        array (
          'param' => 'post_type',
          'operator' => '==',
          'value' => 'addresses',
          'order_no' => 0,
          'group_no' => 0,
        ),
      ),
    ),
    'options' => array (
      'position' => 'normal',
      'layout' => 'default',
      'hide_on_screen' => array (
        0 => 'permalink',
        1 => 'the_content',
        2 => 'excerpt',
        3 => 'custom_fields',
        4 => 'discussion',
        5 => 'comments',
        6 => 'revisions',
        7 => 'slug',
        8 => 'author',
        9 => 'format',
        10 => 'featured_image',
        11 => 'categories',
        12 => 'tags',
        13 => 'send-trackbacks',
      ),
    ),
    'menu_order' => 0,
  ));
  register_field_group(array (
    'id' => 'acf_contact-page',
    'title' => 'Contact Page',
    'fields' => array (
      array (
        'key' => 'field_5a99047703336',
        'label' => 'Telephone',
        'name' => 'telephone',
        'type' => 'text',
        'default_value' => '',
        'placeholder' => '123 456 789',
        'prepend' => '',
        'append' => '',
        'formatting' => 'none',
        'maxlength' => 20,
      ),
      array (
        'key' => 'field_5a9904d003337',
        'label' => 'Email',
        'name' => 'email',
        'type' => 'email',
        'default_value' => '',
        'placeholder' => 'info@email.com',
        'prepend' => '',
        'append' => '',
      ),
    ),
    'location' => array (
      array (
        array (
          'param' => 'page',
          'operator' => '==',
          'value' => '32',
          'order_no' => 0,
          'group_no' => 0,
        ),
      ),
    ),
    'options' => array (
      'position' => 'normal',
      'layout' => 'default',
      'hide_on_screen' => array (
        0 => 'permalink',
        1 => 'the_content',
        2 => 'excerpt',
        3 => 'custom_fields',
        4 => 'discussion',
        5 => 'comments',
        6 => 'revisions',
        7 => 'slug',
        8 => 'author',
        9 => 'format',
        10 => 'featured_image',
        11 => 'categories',
        12 => 'tags',
        13 => 'send-trackbacks',
      ),
    ),
    'menu_order' => 0,
  ));
  register_field_group(array (
    'id' => 'acf_pages-hide-screen-options',
    'title' => 'Pages (hide screen options)',
    'fields' => array (
    ),
    'location' => array (
      array (
        array (
          'param' => 'post_type',
          'operator' => '==',
          'value' => 'page',
          'order_no' => 0,
          'group_no' => 0,
        ),
      ),
    ),
    'options' => array (
      'position' => 'side',
      'layout' => 'no_box',
      'hide_on_screen' => array (
        0 => 'permalink',
        1 => 'excerpt',
        2 => 'custom_fields',
        3 => 'discussion',
        4 => 'comments',
        5 => 'revisions',
        6 => 'slug',
        7 => 'author',
        8 => 'format',
        9 => 'featured_image',
        10 => 'categories',
        11 => 'tags',
        12 => 'send-trackbacks',
      ),
    ),
    'menu_order' => 0,
  ));
}



/*******************************************************************************
 * Include the TGM_Plugin_Activation class.
 */
require_once get_template_directory() . '/class-tgm-plugin-activation.php';

add_action( 'tgmpa_register', 'rafal_ubysz_register_required_plugins' );

/**
 * Register the required plugins for this theme.
 */
function rafal_ubysz_register_required_plugins() {
	/*
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
	$plugins = array(

    // Required plugins
    array(
			'name'               => 'Timber',
			'slug'               => 'timber-library',
			'required'           => true,
			'force_activation'   => true,
    ),

    array(
			'name'               => 'Rafał Ubysz Plugin',
			'slug'               => 'rafal-ubysz-plugin',
			'source'             => 'https://github.com/kamilradziszewski/rafal-ubysz-plugin/archive/master.zip',
      'required'           => true,
      'force_activation'   => true,
    ),

    // Recommended plugins
    array(
			'name'               => 'All-in-One WP Migration',
			'slug'               => 'all-in-one-wp-migration',
    ),

	);

	$config = array(
		'id'           => 'rafal-ubysz',           // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      // Default absolute path to bundled plugins.
		'menu'         => 'tgmpa-install-plugins', // Menu slug.
		'parent_slug'  => 'themes.php',            // Parent menu slug.
		'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => false,                   // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right before the plugins table.
	);

	tgmpa( $plugins, $config );
}
