<?php
/**
 * Astra Child Theme Functions
 * 
 * @package astra-child
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Enqueue parent theme stylesheet and child theme stylesheet
 */
function astra_child_enqueue_styles() {
	wp_enqueue_style( 'astra-parent-style', get_template_directory_uri() . '/style.css' );
	wp_enqueue_style( 'astra-child-style', get_stylesheet_directory_uri() . '/style.css', array( 'astra-parent-style' ), wp_get_theme()->get( 'Version' ) );
	wp_enqueue_style( 'astra-child-responsive', get_stylesheet_directory_uri() . '/responsive.css', array( 'astra-child-style' ), wp_get_theme()->get( 'Version' ) );
}
add_action( 'wp_enqueue_scripts', 'astra_child_enqueue_styles' );

/**
 * Enqueue Font Awesome for icons
 */
function astra_child_enqueue_fontawesome() {
	wp_enqueue_style( 'font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css', array(), '6.4.0' );
}
add_action( 'wp_enqueue_scripts', 'astra_child_enqueue_fontawesome' );

/**
 * Get posts by category with pagination
 * 
 * @param int $category_id The category ID
 * @param int $posts_per_page Number of posts to display
 * @param int $paged Current page number
 * 
 * @return array Array of posts
 */
function get_posts_by_category( $category_id, $posts_per_page = 4, $paged = 1 ) {
	$args = array(
		'cat'              => $category_id,
		'posts_per_page'   => $posts_per_page,
		'paged'            => $paged,
		'post_type'        => 'post',
		'post_status'      => 'publish',
		'orderby'          => 'date',
		'order'            => 'DESC',
	);

	$query = new WP_Query( $args );
	return $query;
}

/**
 * Get all categories with posts (more than 4 posts)
 * 
 * @return array Array of categories
 */
function get_categories_with_posts() {
	$categories = get_categories( array(
		'orderby' => 'name',
		'order'   => 'ASC',
		'hide_empty' => true,
	) );

	// Filter categories to show only those with more than 4 posts
	$filtered_categories = array();
	foreach ( $categories as $category ) {
		if ( $category->count > 4 ) {
			$filtered_categories[] = $category;
		}
	}

	return $filtered_categories;
}

/**
 * Get category icon class based on category name
 * 
 * @param string $category_name The category name
 * 
 * @return string Font Awesome icon class
 */
function get_category_icon( $category_name ) {
	$icons = array(
		'health'              => 'fas fa-heartbeat',
		'education'           => 'fas fa-graduation-cap',
		'agriculture'         => 'fas fa-seedling',
		'women'               => 'fas fa-venus',
		'scholarship'         => 'fas fa-book',
		'pension'             => 'fas fa-money-bill-wave',
		'employment'          => 'fas fa-briefcase',
		'housing'             => 'fas fa-home',
		'welfare'             => 'fas fa-hands-helping',
		'business'            => 'fas fa-store',
		'infrastructure'      => 'fas fa-building',
		'technology'          => 'fas fa-laptop',
		'rural'               => 'fas fa-tree',
		'urban'               => 'fas fa-city',
		'youth'               => 'fas fa-users',
		'senior'              => 'fas fa-user-tie',
		'disability'          => 'fas fa-wheelchair',
		'sc/st'               => 'fas fa-shield-alt',
		'minority'            => 'fas fa-flag',
		'general'             => 'fas fa-folder',
	);

	$category_lower = strtolower( $category_name );
	
	foreach ( $icons as $key => $icon ) {
		if ( stripos( $category_lower, $key ) !== false ) {
			return $icon;
		}
	}

	return 'fas fa-star'; // Default icon
}

/**
 * Get excerpt with custom length
 * 
 * @param int $post_id The post ID
 * @param int $length The excerpt length in words
 * 
 * @return string The excerpt
 */
function get_custom_excerpt( $post_id, $length = 15 ) {
	$post = get_post( $post_id );
	
	if ( $post->post_excerpt ) {
		$excerpt = $post->post_excerpt;
	} else {
		$excerpt = $post->post_content;
	}

	$excerpt = wp_strip_all_tags( $excerpt );
	$excerpt = wp_trim_words( $excerpt, $length, '...' );

	return $excerpt;
}

/**
 * Get featured image URL with fallback
 * 
 * @param int $post_id The post ID
 * 
 * @return string The image URL
 */
function get_featured_image_url( $post_id ) {
	if ( has_post_thumbnail( $post_id ) ) {
		return get_the_post_thumbnail_url( $post_id, 'medium' );
	}

	// Fallback placeholder image
	return get_stylesheet_directory_uri() . '/images/placeholder.jpg';
}

/**
 * Check if blog has categories with posts
 * 
 * @return bool
 */
function has_categories_with_posts() {
	$categories = get_categories_with_posts();
	return ! empty( $categories );
}
