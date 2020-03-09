<?php

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Wpcp
 * @subpackage Wpcp/public
 * 
 */
class Wpcp_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;


	private $permalink_structure;
	private $permalink_permastruct;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

		$this->permalink_structure = '/authors/%first_name_field%';		
		$this->permalink_permastruct = '/authors/%first_name_field%';		

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wpcp_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wpcp_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/public.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Create authors post type
	 *
	 * @since    1.0.0
	 */
	public function add_custom_post_type() {

	
		// Set UI labels for Custom Post Type
		$labels = array(
			'name'                => _x( 'Authors', 'Post Type General Name', 'wpcp' ),
			'singular_name'       => _x( 'Author', 'Post Type Singular Name', 'wpcp' ),
			'menu_name'           => __( 'Authors', 'wpcp' ),
			'parent_item_colon'   => __( 'Parent Author', 'wpcp' ),
			'all_items'           => __( 'All Authors', 'wpcp' ),
			'view_item'           => __( 'View Author', 'wpcp' ),
			'add_new_item'        => __( 'Add New Author', 'wpcp' ),
			'add_new'             => __( 'Add New Author', 'wpcp' ),
			'edit_item'           => __( 'Edit Author', 'wpcp' ),
			'update_item'         => __( 'Update Author', 'wpcp' ),
			'search_items'        => __( 'Search Author', 'wpcp' ),
			'not_found'           => __( 'Author Not Found', 'wpcp' ),
			'not_found_in_trash'  => __( 'Author Not found in Trash', 'wpcp' ),
		);
			
		// Set other options for Custom Post Type				
		$args = array(
			'label'               => __( 'Authors', 'wpcp' ),
			'description'         => __( 'Authors Post Type', 'wpcp' ),
			'labels'              => $labels,
			// Features this CPT supports in Post Editor
			// 'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', ),
			'supports'            => array( 'title', 'thumbnail', 'revisions', 'custom-fields', ),
			'rewrite' => false, // 'rewrite' => array('slug' => 'authors'), // 'slug' => 'publications/%publication-type%/%pubyear%/%pubmonth%',
			// You can associate this Post Type with a taxonomy or custom taxonomy. 
			// 'taxonomies'          => array( 'genres' ),
			/* A hierarchical Post Type is like Pages and can have
			* Parent and child items. A non-hierarchical CPT
			* is like Posts.
			*/ 
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => true,
			'show_in_admin_bar'   => true,
			'menu_position'       => 5,
			'can_export'          => true,
			'has_archive'         => true,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'capability_type'     => 'page',
		);
		
		// Registering your Custom Post Type
		register_post_type( 'authors', $args );

	} 

	/**
	 * Rewrite authors post type URL
	 * Should be accessed at http://url/authors/first_name_field-last_name_field
	 *
	 * @since    1.0.0
	 */
	/*public function wpcp_link_filter($post_link, $id = 0, $leavename = FALSE) {

		if ( strpos('%first_name_field%', $post_link) === 'FALSE' || strpos('%last_name_field%', $post_link) === 'FALSE' ) {
			return $post_link;
		}

		$post = get_post($id);
		if ( !is_object($post) || $post->post_type != 'authors' ) {
			return $post_link;
		}

		// $author = get_userdata($post->post_author);
		// $post_link = str_replace('%author%', $author->user_nicename, $post_link);

		return $post_link;

	}*/

	function wpcp_rewrite_rules() {

		global $wp_rewrite;

		$wp_rewrite->add_rewrite_tag( '%first_name_field%', '([^&]+)', 'first_name_field=');
		// $wp_rewrite->add_rewrite_tag( '%pubmonth%', '([0-9]{2})', 'pubmonth=');

		

	}

	function wpcp_permalink($permalink, $post, $leavename) {
		
		// if ( false !== strpos( $permalink, '%publication-type%/%pubyear%/%pubmonth%' ) ) {
		if ( false !== strpos( $permalink, '%first_name_field%' ) ) {

			$post_id = $post->ID;
   
			$first_name_field = get_post_meta( $post_id, 'first_name_field', true );
			// $pubyear = date('Y', get_post_meta($post->ID, 'publication_date', true));
			// $pubmonth = date('m', get_post_meta($post->ID, 'publication_date', true));

			// SEACH AUTHOR BY META
			/*$args = array(
				'post_type' => 'authors',
				'post' => $post_id,
				'meta_query' => array(
					array(
						'key' => $field,
						'value' => $_GET[$field], 
						'compare' => '=', 
					)
				),
				'relation' => 'AND'
			);*/
   
			$rewritecode = array(
				  // '%publication-type%',
				  '%first_name_field%',
				  // '%pubmonth%',
				  $leavename ? '' : '%postname%',
			);
   
			$rewritereplace = array(
				  // array_pop($publicationtype)->slug,
				  $first_name_field,
				  // $pubmonth,
				  $post->post_name
			);
   
			$permalink = str_replace($rewritecode, $rewritereplace, $permalink);  

	   }

	   return $permalink;

   }

}
