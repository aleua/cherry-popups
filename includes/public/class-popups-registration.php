<?php
/**
 * Cherry Popups registration
 *
 * @package   Cherry_Popups
 * @author    Cherry Team
 * @license   GPL-2.0+
 * @link      http://www.cherryframework.com/
 * @copyright 2014 Cherry Team
 */

/**
 * Class for register post types.
 *
 * @since 1.0.0
 */
class Cherry_Popups_Registration {

	/**
	 * A reference to an instance of this class.
	 *
	 * @since 1.0.0
	 * @var   object
	 */
	private static $instance = null;

	/**
	 * Sets up needed actions/filters.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		// Adds the testimonials post type.
		add_action( 'after_setup_theme', array( __CLASS__, 'register' ) );

		add_action( 'post.php',          array( $this, 'add_post_formats_support' ) );
		add_action( 'load-post.php', array( $this, 'add_post_formats_support' ) );
		add_action( 'load-post-new.php', array( $this, 'add_post_formats_support' ) );

		// Removes rewrite rules and then recreate rewrite rules.
		// add_action( 'init', array( $this, 'rewrite_rules' ) );
	}

	/**
	 * Register the custom post type.
	 *
	 * @since 1.0.0
	 * @link http://codex.wordpress.org/Function_Reference/register_post_type
	 */
	public static function register() {

		$labels = array(
			'name'               => __( 'PopUps', 'cherry-popups' ),
			'singular_name'      => __( 'Popups list', 'cherry-popups' ),
			'add_new'            => __( 'Add Popup', 'cherry-popups' ),
			'add_new_item'       => __( 'Add Popup Item', 'cherry-popups' ),
			'edit_item'          => __( 'Edit Popup Item', 'cherry-popups' ),
			'new_item'           => __( 'New Popup Item', 'cherry-popups' ),
			'view_item'          => __( 'View Popup Item', 'cherry-popups' ),
			'search_items'       => __( 'Search Popup Items', 'cherry-popups' ),
			'not_found'          => __( 'No Popup Items found', 'cherry-popups' ),
			'not_found_in_trash' => __( 'No Popup Items found in trash', 'cherry-popups' ),
		);

		$supports = array(
			'title',
			'editor',
			'thumbnail',
			'revisions',
		);

		$args = array(
			'labels'              => $labels,
			'supports'            => $supports,
			'exclude_from_search' => false,
			'publicly_queryable'  => false,
			'show_in_nav_menus'   => false,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_admin_bar'   => false,
			'capability_type'     => 'post',
			'menu_position'       => null,
			'menu_icon'           => ( version_compare( $GLOBALS['wp_version'], '3.8', '>=' ) ) ? 'dashicons-welcome-add-page' : '',
			'can_export'          => true,
			'has_archive'         => true,
			'taxonomies'          => array( 'post_format' )
		);


		$args = apply_filters( 'cherry_popups_post_type_args', $args );

		register_post_type( CHERRY_POPUPS_NAME, $args );
	}

	/**
	 * Post formats.
	 *
	 * @since 1.0.0
	 * @link http://codex.wordpress.org/Function_Reference/register_taxonomy
	 */
	public function add_post_formats_support() {
		global $typenow;

		if ( CHERRY_POPUPS_NAME != $typenow ) {
			return;
		}
	}

	/**
	 * Rewrite rules
	 *
	 * @return void
	 */
	public function rewrite_rules() {
		flush_rewrite_rules();
	}

	/**
	 * Returns the instance.
	 *
	 * @since  1.0.0
	 * @return object
	 */
	public static function get_instance() {

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance )
			self::$instance = new self;

		return self::$instance;
	}
}

Cherry_Popups_Registration::get_instance();
