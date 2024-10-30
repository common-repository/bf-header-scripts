<?php
/*
Plugin Name: BF Header Scripts

Plugin URI: 

Description: BF Header Scripts

Version: 4.2

Author: EAS

Author URI: 
*/

define( 'BF_HEADER_SCRIPT_VERSION', '4.2' );
define( 'BF_HEADER_SCRIPT_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'BF_HEADER_SCRIPT_PLUGIN_URL', plugin_dir_url(__FILE__) );

function bf_header_style_admin_style() {
  wp_enqueue_style('bf-header-admin-styles', plugins_url('/css/admin-bf-header.css', __FILE__));
}
add_action('admin_enqueue_scripts', 'bf_header_style_admin_style');

add_action('init', 'bf_header_register_script');

function bf_header_register_script() {    wp_register_style('bf-header-css', plugins_url('/css/bf-header.css', __FILE__), false, '1.0.0', 'all');	include_once plugin_dir_path( __FILE__ ) . "/include/inc-bf-header.php";
}
add_action('wp_enqueue_scripts', 'bf_header_enqueue_style');
function bf_header_enqueue_style() {
    wp_enqueue_style('bf-header-css');
}
add_action( 'admin_menu', 'bf_header_menu' );
function bf_header_menu() {
	add_menu_page( 'BF Header Scripts', 'BF Header Scripts', 'manage_options', 'bf-header-options', 'bf_header_options', plugins_url('bf-header-scripts/img/bf-header.png'),
        6);
}

function bf_header_options() {
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	} 		if( isset( $_POST['bf_header_options'])) {	
					$bf_option_name = 'bf_script' ;
					$bf_option_new_value = $_POST['bf_header_options'] ;
					
					if ( get_option( $bf_option_name ) !== false ) {
						update_option( $bf_option_name, $bf_option_new_value );
					} else {
						$deprecated = null;
						$autoload = 'no';
						add_option( $bf_option_name, $bf_option_new_value, $deprecated, $autoload );
						echo 'Data Updated Successfully';
					}
				}	?>
	<?php
	echo '<div class="wrap">';	echo '<form method="post" action="admin.php?page=bf-header-options&action=submit">' . "\n";		wp_nonce_field('bf_header_scripts');		echo '<h2>' . __('BF Header', 'bf-header') . '</h2>' . "\n";		echo '<table class="form-table">' . "\n";	    echo '<tr>' . "\n"
            . '<th scope="row" class="bf-header-option">'	
            . __('Add Script', 'bf-header-script')
            . '</th>' . "\n"
            . '<td>'
            . '<label>'
            . '<textarea name="bf_header_options" id="bf_header_options">'.get_option('bf_script').'</textarea>'
            . '&nbsp;'
            . '</label>'
            . '</td>' . "\n"
            . '</tr>' . "\n";
	echo "</table>\n";
		echo '<div class="submit">'
			. '<input type="submit"'
				. ' value="' . esc_attr(__('Save Changes', 'bf-header-options')) . '"'
				. " />"
			. "</div>\n";
		echo '</form>' . "\n";
	echo '</div>';
}

function bf_script_footer() {
    echo '<script type="text/javascript">'.get_option('bf_script').'</script>';
}
add_action( 'wp_footer', 'bf_script_footer' );
?>