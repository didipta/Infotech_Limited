<?php

/**
 * Next Property functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package NexProperty
 * 
 */

if(file_exists(get_template_directory() . '/freemius/') && !defined('WDK_FS_DISABLE'))
if ( ! function_exists( 'nexproperty_fs' ) ) {
    // Create a helper function for easy SDK access.
    function nexproperty_fs() {
        global $nexproperty_fs;

        if ( ! isset( $nexproperty_fs ) ) {
            // Include Freemius SDK.
            require_once dirname(__FILE__) . '/freemius/start.php';

            $nexproperty_fs = fs_dynamic_init( array(
                'id'                  => '10185',
                'slug'                => 'nexproperty',
                'premium_slug'        => 'nexpropertypro',
                'type'                => 'theme',
                'public_key'          => 'pk_04cd578a64fcf2c92755be17549a1',
                'is_premium'          => true,
                'premium_suffix'      => 'NexProperty Pro',
                // If your theme is a serviceware, set this option to false.
                'has_premium_version' => true,
                'has_addons'          => true,
                'has_paid_plans'      => true,
                'bundle_id'           => '10146',
                'bundle_public_key'   => 'pk_bdd3d117ee39da0096d27df89f166',
                'bundle_license_auto_activation' => true,
                'menu'                => array(
                ),
            ) );
        }

        return $nexproperty_fs;
    }

    // Init Freemius.
    nexproperty_fs();
    // Signal that SDK was initiated.
    do_action( 'nexproperty_fs_loaded' );
}

if ( ! defined( 'NEXPROPERTY_THEME_DIRECTORY' ) ) {
	define( 'NEXPROPERTY_THEME_DIRECTORY', get_template_directory() );
}

if ( ! defined( 'NEXPROPERTY_ASSETS_DIR_URI' ) ) {
	define( 'NEXPROPERTY_ASSETS_DIR_URI', get_template_directory_uri() . '/assets' );
}

if ( ! defined( 'NEXPROPERTY_ASSETS_DIR' ) ) {
	define( 'NEXPROPERTY_ASSETS_DIR', get_template_directory() . '/assets' );
}

if ( ! defined( 'NEXPROPERTY_THEME_VERSION' ) ) {
		define( 'NEXPROPERTY_THEME_VERSION', wp_get_theme( get_template() )->get('Version') );
}

require NEXPROPERTY_THEME_DIRECTORY . '/includes/autoload.php';

require NEXPROPERTY_THEME_DIRECTORY . '/includes/wptt-webfont-loader.php';

function nexproperty_custom_logo (){
    $return = false;
    if(get_theme_mod( 'custom_logo' )) {
        $custom_logo__url = wp_get_attachment_image_src( get_theme_mod( 'custom_logo' ), 'full' ); 
        if (isset($custom_logo__url[0]) && substr_count($custom_logo__url[0], 'media/default.png') == 0) {
             $return = $custom_logo__url[0];
         }
    }
    return $return;
}

/**
 * Fix skip link focus in IE11.
 *
 * This does not enqueue the script because it is tiny and because it is only for IE11,
 * thus it does not warrant having an entire dedicated blocking script being loaded.
 *
 * @link https://git.io/vWdr2
 */
function nexproperty_skip_link_focus_fix() {
	// The following is minified via `terser --compress --mangle -- js/skip-link-focus-fix.js`.
	?>
	<script>
	/(trident|msie)/i.test(navigator.userAgent)&&document.getElementById&&window.addEventListener&&window.addEventListener("hashchange",function(){var t,e=location.hash.substring(1);/^[A-z0-9_-]+$/.test(e)&&(t=document.getElementById(e))&&(/^(?:a|select|input|button|textarea)$/i.test(t.tagName)||(t.tabIndex=-1),t.focus())},!1);
	</script>
	<?php
}
add_action( 'wp_print_footer_scripts', 'nexproperty_skip_link_focus_fix' );

$message = '<p><strong>' . sprintf( '%s <a href="%s" class="button button-primary">%s</a>', esc_html__( 'We recommend import demo content for theme NexProperty: ', 'nexproperty' ), admin_url('themes.php?page=one-click-demo-import'), esc_html__( 'import now', 'nexproperty' ) ) . '</strong></p>';

if(!is_child_theme())
{
    nexproperty_notify_admin('fail_load', $message, function()
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
} 
/*
* Add admin notify
* @param (string) $key unique key of notify, prefix included related plugin
* @param (string) $text test of message
* @param (function) $callback_filter custom function should be return true if not need show
* @param (string) $class notify alert class, by default 'notice notice-error'
* @return boolen true 
*/
function nexproperty_notify_admin ($key = '', $text = 'Custom Text of message', $callback_filter = '', $class = 'notice notice-error') {
    $key = 'nexproperty_notify_'.$key;
    $key_diss = $key.'_dissmiss';

    $nexproperty_notinstalled_admin_notice__error = function () use ($key_diss, $text, $class, $callback_filter) {
        global $wpdb;
        $user_id = get_current_user_id();
        if (!get_user_meta($user_id, $key_diss)) {
            if(!empty($callback_filter)) if($callback_filter()) return false;

            $message = '';
            $message .= $text;
            printf('<div class="%1$s" style="position:relative;"><p>%2$s</p><a href="?'.$key_diss.'"><button type="button" class="notice-dismiss"></button></a></div>', esc_html($class), ($message));  // WPCS: XSS ok, sanitization ok.
        }
    };

    add_action('admin_notices', function () use ($nexproperty_notinstalled_admin_notice__error) {
        $nexproperty_notinstalled_admin_notice__error();
    });

    $nexproperty_notinstalled_admin_notice__error_dismissed = function () use ($key_diss) {
        $user_id = get_current_user_id();
        if (isset($_GET[$key_diss]))
            add_user_meta($user_id, $key_diss, 'true', true);
    };
    add_action('admin_init', function () use ($nexproperty_notinstalled_admin_notice__error_dismissed) {
        $nexproperty_notinstalled_admin_notice__error_dismissed();
    });

    return true;
}

function nexproperty_search_filter( $query ) {
    if ( $query->is_search)
        $query->set( 'post_type', array( 'post', 'movie', 'book' ) );

    return $query;
}
add_filter( 'pre_get_posts', 'nexproperty_search_filter' );
