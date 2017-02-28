<?php
/**
 * Security, checks if WordPress is running
 **/
if ( !function_exists( 'add_action' ) ) :
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit();
endif;



/**
*  Plugin
*/
final class Custom_Post_Type_Sponsor
{



	/**
	 * Constructor
	 *
	 * @access public
	 * @return void
	 * @author Ralf Hortt <me@horttcore.de>
	 * @since v1.1.0
	 **/
	public function __construct()
	{

		add_action( 'init', array( $this, 'register_post_type' ) );
		add_action( 'init', array( $this, 'register_taxonomy' ) );
		add_action( 'plugins_loaded', array( $this, 'load_plugin_textdomain' ) );

	} // END __construct



	/**
	 * Load plugin translation
	 *
	 * @access public
	 * @return void
	 * @author Ralf Hortt <me@horttcore.de>
	 * @since v1.1.0
	 **/
	public function load_plugin_textdomain()
	{

		load_plugin_textdomain( 'custom-post-type-sponsors', false, dirname( plugin_basename( __FILE__ ) ) . '/../languages/'  );

	} // END load_plugin_textdomain



	/**
	 * Register post type
	 *
	 * @access public
	 * @return void
	 * @since v1.1.0
	 * @author Ralf Hortt <me@horttcore.de>
	 **/
	public function register_post_type()
	{

		register_post_type( 'sponsor', array(
			'labels' => array(
				'name' => _x( 'Sponsors', 'post type general name', 'custom-post-type-sponsors' ),
				'singular_name' => _x( 'Sponsor', 'post type singular name', 'custom-post-type-sponsors' ),
				'add_new' => _x( 'Add New', 'Sponsor', 'custom-post-type-sponsors' ),
				'add_new_item' => __( 'Add New Sponsor', 'custom-post-type-sponsors' ),
				'edit_item' => __( 'Edit Sponsor', 'custom-post-type-sponsors' ),
				'new_item' => __( 'New Sponsor', 'custom-post-type-sponsors' ),
				'view_item' => __( 'View Sponsor', 'custom-post-type-sponsors' ),
				'view_items' => __( 'View Sponsors', 'custom-post-type-sponsors' ),
				'search_items' => __( 'Search Sponsors', 'custom-post-type-sponsors' ),
				'not_found' =>  __( 'No Sponsors found', 'custom-post-type-sponsors' ),
				'not_found_in_trash' => __( 'No Sponsors found in Trash', 'custom-post-type-sponsors' ),
				'parent_item_colon' => __( 'Parent Sponsor:', 'custom-post-type-sponsors' ),
				'all_items' => __( 'All Sponsors', 'custom-post-type-sponsors' ),
				'archives' => __( 'Sponsor Archives', 'custom-post-type-sponsors' ),
				'attributes' => __( 'Sponsor Attributes', 'custom-post-type-sponsors' ),
				'insert_into_item' => __( 'Insert into sponsor', 'custom-post-type-sponsors' ),
				'uploaded_to_this_item' => __( 'Uploaded to this sponsor', 'custom-post-type-sponsors' ),
				'featured_image' => __( 'Featured Image', 'custom-post-type-sponsors' ),
				'set_featured_image' => __( 'Set featured image', 'custom-post-type-sponsors' ),
				'remove_featured_image' => __( 'Remove featured image', 'custom-post-type-sponsors' ),
				'use_featured_image' => __( 'Use as featured image', 'custom-post-type-sponsors' ),
				'filter_items_list' => __( 'Filter sponsors list', 'custom-post-type-sponsors' ),
				'items_list_navigation' => __( 'Sponsors list navigation', 'custom-post-type-sponsors' ),
				'items_list' => __( 'Sponsors list', 'custom-post-type-sponsors' ),
			),
			'public' => TRUE,
			'publicly_queryable' => TRUE,
			'show_ui' => TRUE,
			'show_in_menu' => TRUE,
			'query_var' => TRUE,
			'rewrite' => array(
				'slug' => _x( 'sponsors', 'Sponsors slug', 'custom-post-type-sponsors' ),
				'with_front' => FALSE,
			),
			'capability_type' => 'post',
			'has_archive' => FALSE,
			'hierarchical' => FALSE,
			'menu_position' => NULL,
			'menu_icon' => 'dashicons-admin-links',
			'supports' => array( 'title', 'editor', 'thumbnail', 'page-attributes' )
		) );

	} // END register_post_type



	/**
	 * Register taxonomy
	 *
	 * @access public
	 * @since 2.0
	 * @author Ralf Hortt
	 */
	public function register_taxonomy()
	{

		register_taxonomy( 'sponsor-category',array( 'sponsor' ), array(
			'hierarchical' => TRUE,
			'labels' => array(
				'name' => _x( 'Sponsor Categories', 'taxonomy general name', 'custom-post-type-sponsors' ),
				'singular_name' => _x( 'Sponsor Category', 'taxonomy singular name', 'custom-post-type-sponsors' ),
				'search_items' =>  __( 'Search Sponsor Categories', 'custom-post-type-sponsors' ),
				'popular_items' =>  __( 'Popular Sponsor Categories', 'custom-post-type-sponsors' ),
				'all_items' => __( 'All Sponsor Categories', 'custom-post-type-sponsors' ),
				'parent_item' => __( 'Parent Sponsor Category', 'custom-post-type-sponsors' ),
				'parent_item_colon' => __( 'Parent Sponsor Category:', 'custom-post-type-sponsors' ),
				'edit_item' => __( 'Edit Sponsor Category', 'custom-post-type-sponsors' ),
				'view_item' => __( 'View Sponsor Category', 'custom-post-type-sponsors' ),
				'update_item' => __( 'Update Sponsor Category', 'custom-post-type-sponsors' ),
				'add_new_item' => __( 'Add New Sponsor Category', 'custom-post-type-sponsors' ),
				'new_item_name' => __( 'New Sponsor Category Name', 'custom-post-type-sponsors' ),
				'separate_items_with_commas' => __( 'Separate sponsor categories with commas', 'custom-post-type-sponsors' ),
				'add_or_remove_items' => __( 'Add or remove sponsor categories', 'custom-post-type-sponsors' ),
				'choose_from_most_used' => __( 'Choose from the most used sponsor categories', 'custom-post-type-sponsors' ),
				'not_found' => __( 'No sponsor categories found', 'custom-post-type-sponsors' ),
				'no_terms' => __( 'No sponsor categories', 'custom-post-type-sponsors' ),
				'items_list_navigation' => __( 'Sponsor Categories list navigation', 'custom-post-type-sponsors' ),
				'items_list' => __( 'Sponsor Categories list', 'custom-post-type-sponsors' ),
			),
			'show_ui' => TRUE,
			'show_admin_column' => TRUE,
			'query_var' => TRUE,
			'rewrite' => array(
				'slug' => _x( 'sponsor-category', 'Slug', 'custom-post-type-sponsors' ),
			)
		) );

	} // END register_taxonomy



}

new Custom_Post_Type_Sponsor;
