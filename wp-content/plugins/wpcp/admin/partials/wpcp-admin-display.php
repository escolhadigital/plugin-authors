<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       joelrocha.com
 * @since      1.0.0
 *
 * @package    Wpcp
 * @subpackage Wpcp/admin/partials
 * 
 *
 *    
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<div class="wrap">
  <h2><?php echo esc_html(get_admin_page_title()); ?></h2>  
  <form method="post" name="wpcp_options" action="options.php">
  
    <?php    
      // Grab all options
      $options = get_option($this->plugin_name);
      settings_fields($this->plugin_name);
      do_settings_sections($this->plugin_name);
    ?>
    
    <h3>Options</h3>

    <fieldset>
      <label for="<?php echo $this->plugin_name; ?>-field_name">
        <span>Field Example</span>
        <input type="input" id="<?php echo $this->plugin_name; ?>-field_name" name="<?php echo $this->plugin_name; ?>[field_name]" 
          value="<?php echo $options['field_name']; ?>" />
        <span>Example: xxxxxxxx</span>     
      </label>
    </fieldset> 
  
    <?php submit_button('Save all changes', 'primary', 'submit', TRUE); ?>
    
  </form>
</div>
