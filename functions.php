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





/***************************************************************************
 * Enqueue scripts and styles
 */
function rafal_ubysz_scripts_and_styles() {
	wp_enqueue_style( 'rafal-ubysz-main', get_stylesheet_directory_uri() . '/static/dist/css/main.css' );
	

	wp_enqueue_script(	'googleapis',
											'https://maps.googleapis.com/maps/api/js?key=AIzaSyDuvAWwm23t9fAC-8iYUwd5Enb60ALjfS0',
											false,
											false,
											true );

	wp_enqueue_script(	'acf-googlemaps',
											get_stylesheet_directory_uri() . '/static/dist/js/googlemaps.js',
											array('jquery'),
											false,
											true );
}
add_action( 'wp_enqueue_scripts', 'rafal_ubysz_scripts_and_styles' );



/***************************************************************************
 * Register Google API Key
 */
function my_acf_google_map_api( $api ){
	$api['key'] = 'AIzaSyDuvAWwm23t9fAC-8iYUwd5Enb60ALjfS0';
	return $api;
}
add_filter('acf/fields/google_map/api', 'my_acf_google_map_api');
