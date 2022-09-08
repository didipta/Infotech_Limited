<?php
/**
 * Nexproperty Child Theme Custom Functions
**/

/**
 * Localize
 * Since 1.0
 */
 if( ! function_exists( 'car_dealer_nexcars_localize' ) ) {
	 
	add_action('after_setup_theme', 'car_dealer_nexcars_localize');

	function car_dealer_nexcars_localize(){
		load_child_theme_textdomain( 'car-dealer-nexcars' , get_stylesheet_directory().'/languages');
	}
 }

 /* Enqueue Child Theme Scripts & Styles 
 ** http://codex.wordpress.org/Function_Reference/wp_enqueue_style
 * Since 1.0
 */
 
add_action( 'wp_enqueue_scripts', 'car_dealer_nexcars_styles' );	

if( ! function_exists( 'car_dealer_nexcars_styles' ) ) {	

	function car_dealer_nexcars_styles() {	
					
		wp_enqueue_style(
			'layers-parent-style',
			get_template_directory_uri() . '/style.css',
			array()
		); // Parent Stylsheet for Version info

		
	}
	
}
if( ! function_exists( 'car_dealer_nexcars_scripts' ) ) {
		
	function car_dealer_nexcars_scripts() {
		
		wp_enqueue_script(
			'car-dealer-nexcars' . '-custom',
			get_stylesheet_directory_uri() . '/assets/js/theme.js',
			array(
				'jquery', // make sure this only loads if jQuery has loaded
			)
		); // Custom Child Theme jQuery  
		
	}	
	
}
// Output this in the footer before anything else
// http://codex.wordpress.org/Plugin_API/Action_Reference/wp_footer
add_action('wp_enqueue_scripts', 'car_dealer_nexcars_scripts'); 
 

/**
* Add Sub Menu Page to the Layers Menu Item
*/
if( ! function_exists('car_dealer_nexcars_register_submenu_page') ) {
	function car_dealer_nexcars_register_submenu_page(){
		add_theme_page( __( 'Car Dealer NexCars Help' , 'car-dealer-nexcars'  ), __( 'Car Dealer NexCars Help' , 'car-dealer-nexcars'  ), 
							'edit_theme_options', 'car_dealer_nexcars-dashboard', 'get_child_onboarding' );
	}
}
function get_child_onboarding(){
	require_once get_stylesheet_directory() . '/includes/theme-help.php';
}
add_action('admin_menu', 'car_dealer_nexcars_register_submenu_page', 60);

/**
* Welcome Redirect
* http://docs.layerswp.com/how-to-add-help-pages-onboarding-to-layers-themes-or-extensions/
*/
function car_dealer_nexcars_setup(){
	if( isset($_GET["activated"]) && $pagenow = "themes.php" ) { //&& '' == get_option( 'layers_welcome' )
		update_option( 'layers_welcome' , 1);
	}
}
add_action( 'after_setup_theme' , 'car_dealer_nexcars_setup', 20 );



$message = '<p><strong>' . sprintf( '%s <a href="%s" class="button button-primary">%s</a>', esc_html__( 'We recommend import demo content for theme Car Dealer NexCars: ', 'car-dealer-nexcars' ), admin_url('themes.php?page=one-click-demo-import'), esc_html__( 'import now', 'car-dealer-nexcars' ) ) . '</strong></p>';
car_dealer_nexcars_notify_admin('fail_load', $message, function()
										{
                                            if( isset($_GET['page']) && $_GET['page'] == 'one-click-demo-import' ) return true;
                                            
											if ( !in_array( 'one-click-demo-import/one-click-demo-import.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
												// do stuff only if ocdi is installed and active
                                                return true;
											}

											if ( in_array( 'wpdirectorykit/wpdirectorykit.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) )  && function_exists('wdk_get_instance')) {
                                                $WMVC = &wdk_get_instance();
                                                $WMVC->model('field_m');
                                                $wdk_fields = $WMVC->field_m->get();
                                                if(count($wdk_fields) > 0) 
                                                    return true;
											}

                                            return false;

										}, 'notice notice-warning'
	);
        
/*
* Add admin notify
* @param (string) $key unique key of notify, prefix included related plugin
* @param (string) $text test of message
* @param (function) $callback_filter custom function should be return true if not need show
* @param (string) $class notify alert class, by default 'notice notice-error'
* @return boolen true 
*/
function car_dealer_nexcars_notify_admin ($key = '', $text = 'Custom Text of message', $callback_filter = '', $class = 'notice notice-error') {
    $key = 'car_dealer_nexcars_notify_'.$key;
    $key_diss = $key.'_dissmiss';

    $car_dealer_nexcars_notinstalled_admin_notice__error = function () use ($key_diss, $text, $class, $callback_filter) {
        global $wpdb;
        $user_id = get_current_user_id();
        if (!get_user_meta($user_id, $key_diss)) {
            if(!empty($callback_filter)) if($callback_filter()) return false;

            $message = '';
            $message .= $text;
            printf('<div class="%1$s" style="position:relative;"><p>%2$s</p><a href="?'.$key_diss.'"><button type="button" class="notice-dismiss"></button></a></div>', esc_html($class), ($message));  // WPCS: XSS ok, sanitization ok.
        }
    };

    add_action('admin_notices', function () use ($car_dealer_nexcars_notinstalled_admin_notice__error) {
        $car_dealer_nexcars_notinstalled_admin_notice__error();
    });

    $car_dealer_nexcars_notinstalled_admin_notice__error_dismissed = function () use ($key_diss) {
        $user_id = get_current_user_id();
        if (isset($_GET[$key_diss]))
            add_user_meta($user_id, $key_diss, 'true', true);
    };
    add_action('admin_init', function () use ($car_dealer_nexcars_notinstalled_admin_notice__error_dismissed) {
        $car_dealer_nexcars_notinstalled_admin_notice__error_dismissed();
    });

    return true;
}



/**
 * Admin styles.
 *
 */
function car_dealer_nexcars_custom_admin_styles() {
    echo '<style>
      .appearance_page_car_dealer_nexcars-dashboard #setting-error-tgmpa {
        margin-left: 0;
      }
    </style>';
  }
  add_action('admin_head', 'car_dealer_nexcars_custom_admin_styles');

?>