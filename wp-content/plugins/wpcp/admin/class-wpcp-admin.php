<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wpcp
 * @subpackage Wpcp/admin
 * 
 */
class Wpcp_Admin {

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
	 * @var      string    $version   The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name   The name of this plugin.
	 * @param      string    $version       The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/admin.js', array( 'jquery' ), $this->version, false );

	}
  
  /**
   * Register the administration menu for this plugin into the WordPress Dashboard menu.
   *
   * @since    1.0.0
   */
  
  public function add_plugin_admin_menu() {

    /*
     * Add a settings page for this plugin to the Settings menu.
     *
     * NOTE:  Alternative menu locations are available via WordPress administration menu functions.
     *
     * Administration Menus: http://codex.wordpress.org/Administration_Menus
     *
     */
    add_options_page( 'WP Custom Plugin', 'WP Custom Plugin', 'manage_options', 
      $this->plugin_name, array($this, 'display_plugin_setup_page')
    );
  }
  
   /**
   * Add settings action link to the plugins page.
   *
   * @since    1.0.0
   */
  
  public function add_action_links( $links ) {
  
      /*
      *  Documentation : https://codex.wordpress.org/Plugin_API/Filter_Reference/plugin_action_links_(plugin_file_name)
      */
      
     $settings_link = array(
      '<a href="' . admin_url( 'options-general.php?page=' . $this->plugin_name ) . '">' . __('Settings WP Custom Plugin', $this->plugin_name) . '</a>',
     );
     return array_merge(  $settings_link, $links );
  
  }
  
  /**
   * Render the settings page for this plugin.
   *
   * @since    1.0.0
   */
  
  public function display_plugin_setup_page() {
  
    include_once( 'partials/wpcp-admin-display.php' );   
    
  }
  
  /**
  *
  * On Option update
  *
  * @since    1.0.0  
  **/
   public function options_update() {
      register_setting($this->plugin_name, $this->plugin_name, array($this, 'validate'));
   }
  
  /**
  *
  * Field Validation
  *
  * @since    1.0.0  
  **/
  public function validate($input) {
  
      // All checkboxes inputs        
      $valid = array();
      $valid['field_name'] = $input['field_name'];
  
      return $valid;
      
  }
   
  // GET OPTIONS 
  public function getOptions() {

    $options = get_option($this->plugin_name);
    return $options;
 
  }

  /**
	 * Adds a metabox to the post type
	 *
	 * @since    1.0.0
   */
   
	function wpcp_add_metabox() {

		add_meta_box(
			'wpcp_authors_metabox',
			'Author Meta',
			array( $this, 'wpcp_add_meta_fields' ),
			'authors',
			'normal',	// normal, side and advanced
			'default'
		);

	}

	/**
	* Output the HTML for the metabox.
  */
  
	function wpcp_add_meta_fields() {

		global $post;

		// Nonce field to validate form request came from current site
		wp_nonce_field( basename( __FILE__ ), 'author_fields' );

		// Get meta if it's already been entered
		$first_name = get_post_meta( $post->ID, 'first_name_field', true );
		$last_name = get_post_meta( $post->ID, 'last_name_field', true );
		$biography = get_post_meta( $post->ID, 'biography_field', true );
		$facebook_url = get_post_meta( $post->ID, 'facebook_url_field', true );
		$linkedin_url = get_post_meta( $post->ID, 'linkedin_url_field', true );
		$wordpress_user_id = get_post_meta( $post->ID, 'last_name_field', true );
		// $image = get_post_meta( $post->ID, 'last_name_field', true );
		$gallery = get_post_meta( $post->ID, 'last_name_field', true );

    // Output the field
?>    
    <fieldset>
      <label for="first_name_field">First Name: </label>
      <input type="text" name="first_name_field" value="<?php echo esc_textarea( $first_name ); ?>" >
    </fieldset>   

    <fieldset>
      <label for="last_name_field">Last Name: </label>
      <input type="text" name="last_name_field" value="<?php echo esc_textarea( $last_name ); ?>">
    </fieldset> 
    
    <fieldset>
      <label for="biography_field">Biography</label>
      <textarea type="text" name="biography_field" class="widefat"><?php echo esc_textarea( $biography ); ?></textarea>
    </fieldset> 

<?php
		/*
			- Option to link this author to an existing WordPress user 
            (either a dropdown with WordPress users or a text field to enter a WordPress user ID)
		*/ 

	}

	/**
	 * Save the metabox data
	 *
	 * @since    1.0.0
   */
   
	function wpcp_save_meta( $post_id, $post ) {

		// Return if the user doesn't have edit permissions.
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return $post_id;
		}

		// Verify this came from the our screen and with proper authorization,
		// because save_post can be triggered at other times.
		if ( ! wp_verify_nonce( $_POST['author_fields'], basename(__FILE__) ) ) {
			return $post_id;
		}

		// Now that we're authenticated, time to save the data.
		// This sanitizes the data from the field and saves it into an array.
    $meta_fields['first_name_field'] = esc_textarea( $_POST['first_name_field'] );
    $meta_fields['last_name_field'] = esc_textarea( $_POST['last_name_field'] );
    $meta_fields['biography_field'] = esc_textarea( $_POST['biography_field'] );

		// Cycle through the $events_meta array.
		// Note, in this example we just have one item, but this is helpful if you have multiple.
		foreach ( $meta_fields as $key => $value ) :
			// Don't store custom data twice
			if ( 'revision' === $post->post_type ) {
			  return;
			}
			if ( get_post_meta( $post_id, $key, false ) ) {
				// If the custom field already has a value, update it.
				update_post_meta( $post_id, $key, $value );
			} else {
				// If the custom field doesn't have a value, add it.
				add_post_meta( $post_id, $key, $value);
			}
			if ( ! $value ) {
				// Delete the meta key if there's no value
				delete_post_meta( $post_id, $key );
			}
		endforeach;

	}

 
}
