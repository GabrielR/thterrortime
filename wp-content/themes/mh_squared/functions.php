<?php

/***** Fetch Options *****/

$mh_squared_options = get_option('mh_squared_options');

/***** Custom Hooks *****/

function mh_squared_before_page_content() {
    do_action('mh_squared_before_page_content');
}

function mh_squared_before_post_content() {
    do_action('mh_squared_before_post_content');
}

/***** Theme Setup *****/

if (!function_exists('mh_squared_theme_setup')) {
	function mh_squared_theme_setup() {
		$header = array(
			'default-image'	=> '',
			'default-text-color' => 'ffffff',
			'width' => 320,
			'height' => 110,
			'flex-width' => true,
			'flex-height' => true
		);
		add_theme_support('custom-header', $header);
		add_theme_support('title-tag');
		add_theme_support('automatic-feed-links');
		add_theme_support('html5', array('search-form'));
		add_theme_support('custom-background', array('default-color' => '000'));
		add_theme_support('post-thumbnails');
		add_theme_support('infinite-scroll', array('type' => 'click', 'container' => 'mh-infinite'));
		add_image_size('mh-squared-slider', 732, 377, true);
		add_image_size('mh-squared-content', 682, 351, true);
		add_image_size('mh-squared-grid', 329, 329, true);
		add_image_size('mh-squared-small', 80, 80, true);
		add_filter('use_default_gallery_style', '__return_false');
		add_filter('widget_text', 'do_shortcode');
		add_post_type_support('page', 'excerpt');
		load_theme_textdomain('mh-squared', get_template_directory() . '/languages');
		register_nav_menus(array(
			'header_nav' => __('Header Navigation', 'mh-squared'),
			'main_nav' => __('Main Navigation', 'mh-squared'),
			'social_nav' => __('Footer Social Icons', 'mh-squared')
		));
	}
}
add_action('after_setup_theme', 'mh_squared_theme_setup');

/***** Set Content Width *****/

if (!function_exists('mh_squared_content_width')) {
	function mh_squared_content_width() {
		global $content_width;
		if (!isset($content_width)) {
			if (is_page_template('template-full.php')) {
				$content_width = 1060;
			} else {
				$content_width = 682;
			}
		}
	}
}
add_action('template_redirect', 'mh_squared_content_width');

/***** Add Backwards Compatibility for Title Tag *****/

if (!function_exists('_wp_render_title_tag')) {
	function mh_squared_render_title() { ?>
		<title><?php wp_title('|', true, 'right'); ?></title><?php
	}
	add_action('wp_head', 'mh_squared_render_title');
}

/***** Load CSS & JavaScript *****/

if (!function_exists('mh_squared_scripts')) {
	function mh_squared_scripts() {
		wp_enqueue_style('mh-style', get_stylesheet_uri(), false, '1.0.1');
		wp_enqueue_style('mh-fontawesome', "//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css", array(), null);
		wp_enqueue_script('mh-scripts', get_template_directory_uri() . '/js/scripts.js', array('jquery'));
		if (!is_admin()) {
			if (is_singular() && comments_open() && (get_option('thread_comments') == 1))
				wp_enqueue_script('comment-reply');
		}
	}
}
add_action('wp_enqueue_scripts', 'mh_squared_scripts');

if (!function_exists('mh_squared_admin_scripts')) {
	function mh_squared_admin_scripts($hook) {
		if ('appearance_page_squared' === $hook || 'widgets.php' === $hook) {
			wp_enqueue_style('mh-admin', get_template_directory_uri() . '/admin/admin.css');
		}
	}
}
add_action('admin_enqueue_scripts', 'mh_squared_admin_scripts');

/***** Register Widget Areas / Sidebars	*****/

if (!function_exists('mh_squared_widgets_init')) {
	function mh_squared_widgets_init() {
		register_sidebar(array('name' => __('Global - Sidebar', 'mh-squared'), 'id' => 'global-sidebar', 'description' => __('Sidebar widgets located on every page except the homepage, suitable for all widgets.', 'mh-squared'), 'before_widget' => '<div class="sb-widget %2$s">', 'after_widget' => '</div>', 'before_title' => '<h4 class="widget-title">', 'after_title' => '</h4>'));
		register_sidebar(array('name' => __('Header - Advertisement (Top)', 'mh-squared'), 'id' => 'header-ad-top', 'description' => __('Advertisement position located within the header alongside the logo, suitable for a single text widget.', 'mh-squared'), 'before_widget' => '<div class="header-ad-widget %2$s">', 'after_widget' => '</div>', 'before_title' => '<h4 class="widget-title">', 'after_title' => '</h4>'));
		register_sidebar(array('name' => __('Header - Advertisement (Bottom)', 'mh-squared'), 'id' => 'header-ad-bottom', 'description' => __('Advertisement position located below the header above every page, suitable for a single text widget.', 'mh-squared'), 'before_widget' => '<div class="top-ad-widget %2$s">', 'after_widget' => '</div>', 'before_title' => '<h4 class="widget-title">', 'after_title' => '</h4>'));
		register_sidebar(array('name' => __('Home 1 - Main Column', 'mh-squared'), 'id' => 'home-main-column', 'description' => __('Main column widgets located on homepage only, suitable for widgets with the [MH] prefix and text widgets.', 'mh-squared'), 'before_widget' => '<div class="home-main-widget %2$s">', 'after_widget' => '</div>', 'before_title' => '<h4 class="widget-title">', 'after_title' => '</h4>'));
		register_sidebar(array('name' => __('Home 2 - Sidebar', 'mh-squared'), 'id' => 'home-sidebar', 'description' => __('Sidebar widgets located on homepage only, suitable for all widgets.', 'mh-squared'), 'before_widget' => '<div class="sb-widget %2$s">', 'after_widget' => '</div>', 'before_title' => '<h4 class="widget-title">', 'after_title' => '</h4>'));
		register_sidebar(array('name' => __('Posts 1 - Advertisement (Top)', 'mh-squared'), 'id' => 'post-ad-1', 'description' => __('Advertisement position located above the post content, suitable for a single text widget.', 'mh-squared'), 'before_widget' => '<div class="post-ad-top-widget %2$s">', 'after_widget' => '</div>', 'before_title' => '<h4 class="widget-title">', 'after_title' => '</h4>'));
		register_sidebar(array('name' => __('Posts 2 - Advertisement (Bottom)', 'mh-squared'), 'id' => 'post-ad-2', 'description' => __('Advertisement position located below the post contents, suitable for a single text widget.', 'mh-squared'), 'before_widget' => '<div class="post-ad-bottom-widget %2$s">', 'after_widget' => '</div>', 'before_title' => '<h4 class="widget-title">', 'after_title' => '</h4>'));
		register_sidebar(array('name' => __('Footer - Advertisement', 'mh-squared'), 'id' => 'footer-ad', 'description' => __('Advertisement position located above the footer on every page, suitable for a single text widget.', 'mh-squared'), 'before_widget' => '<div class="footer-ad-widget %2$s">', 'after_widget' => '</div>', 'before_title' => '<h4 class="widget-title">', 'after_title' => '</h4>'));
		register_sidebar(array('name' => __('Footer 1 - First Column', 'mh-squared'), 'id' => 'footer-1', 'description' => __('Footer widgets located at the bottom of every page.', 'mh-squared'), 'before_widget' => '<div class="footer-widget %2$s">', 'after_widget' => '</div>', 'before_title' => '<h4 class="widget-title">', 'after_title' => '</h4>'));
		register_sidebar(array('name' => __('Footer 2 - Second Column', 'mh-squared'), 'id' => 'footer-2', 'description' => __('Footer widgets located at the bottom of every page.', 'mh-squared'), 'before_widget' => '<div class="footer-widget %2$s">', 'after_widget' => '</div>', 'before_title' => '<h4 class="widget-title">', 'after_title' => '</h4>'));
		register_sidebar(array('name' => __('Footer 3 - Third Column', 'mh-squared'), 'id' => 'footer-3', 'description' => __('Footer widgets located at the bottom of every page.', 'mh-squared'), 'before_widget' => '<div class="footer-widget %2$s">', 'after_widget' => '</div>', 'before_title' => '<h4 class="widget-title">', 'after_title' => '</h4>'));
		register_sidebar(array('name' => __('Contact - Sidebar', 'mh-squared'), 'id' => 'contact-sidebar', 'description' => __('Sidebar widgets located on the contact page template only, suitable for all widgets.', 'mh-squared'), 'before_widget' => '<div class="sb-widget %2$s">', 'after_widget' => '</div>', 'before_title' => '<h4 class="widget-title">', 'after_title' => '</h4>'));
	}
}
add_action('widgets_init', 'mh_squared_widgets_init');

/***** Include Several Functions *****/

require_once('includes/mh-options.php');
require_once('includes/mh-custom-functions.php');
require_once('includes/mh-helper-functions.php');
require_once('includes/mh-widgets.php');
require_once('includes/mh-google-webfonts.php');
require_once('includes/mh-breadcrumb.php');

if (is_admin()) {
	require_once('admin/admin.php');
}

?>