<?php

// No direct access, please
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Some Definition
 */
define('FLEXIA_DEV_MODE', false);

/**
 * Flexia functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Flexia
 */

if (!function_exists('flexia_setup')) {
    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which
     * runs before the init hook. The init hook is too late for some features, such
     * as indicating support for post thumbnails.
     */
    function flexia_setup()
    {
        /*
         * Make theme available for translation.
         * Translations can be filed in the /languages/ directory.
         * If you're building a theme based on Flexia, use a find and replace
         * to change 'flexia' to the name of your theme in all the template files.
         */
        load_theme_textdomain('flexia', get_template_directory() . '/languages');

        // Add default posts and comments RSS feed links to head.
        add_theme_support('automatic-feed-links');

        /*
         * Let WordPress manage the document title.
         * By adding theme support, we declare that this theme does not use a
         * hard-coded <title> tag in the document head, and expect WordPress to
         * provide it for us.
         */
        add_theme_support('title-tag');

        /*
         * Enable support for Post Thumbnails on posts and pages.
         *
         * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
         */
        add_theme_support('post-thumbnails');

        add_image_size('flexia-featured-image', 2000, 1200, true);

        add_image_size('flexia-thumbnail-avatar', 100, 100, true);
        /*
         * This theme styles the visual editor to resemble the theme style
         */
        add_editor_style(get_template_directory() . '/framework/assets/admin/css/editor-style.css');

        /**
         * Register primary menu
         */
        register_nav_menus(array(
            'primary' => esc_html__('Primary Menu', 'flexia'),
            'topbar-menu' => esc_html__('Topbar Menu', 'flexia'),
            'footer-menu' => esc_html__('Footer Menu', 'flexia'),
        ));

        /**
         * Add SVG Support to flexia
         */
        add_filter('wp_kses_allowed_html', function ($tags) {

            $tags['svg'] = array(
                'xmlns' => array(),
                'fill' => array(),
                'viewbox' => array(),
                'role' => array(),
                'aria-hidden' => array(),
                'focusable' => array(),
            );
            $tags['path'] = array(
                'd' => array(),
                'fill' => array(),
            );
            return $tags;
        }, 10, 2);

        /**
         * Add search box to header navigation
         */

        function flexia_nav_search($items)
        {
            $flexia_nav_menu_search = get_theme_mod('flexia_nav_menu_search', true);

            if ($flexia_nav_menu_search == true) {
                $items .= '<li class="menu-item navbar-search-menu">';
                $items .= '<span id="btn-search">';
                $items .= '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 448.1 448.1" style="enable-background:new 0 0 448.1 448.1;" xml:space="preserve"><path d="M438.6,393.4L334.8,289.5c21-29.9,33.3-66.3,33.3-105.5C368,82.4,285.7,0.1,184.1,0C82.5,0,0.1,82.4,0.1,184 s82.4,184,184,184c39.2,0,75.6-12.3,105.4-33.2l103.8,103.9c12.5,12.5,32.8,12.5,45.3,0C451.1,426.2,451.1,405.9,438.6,393.4z M184.1,304c-66.3,0-120-53.7-120-120s53.7-120,120-120s120,53.7,120,120C304,250.2,250.3,303.9,184.1,304z"/></svg>';
                $items .= '</span>';
                $items .= '</li>';
            }
            return $items;
        }
        add_filter('flexia_header_icon_items', 'flexia_nav_search', 98, 1);

        /**
         * Add Login Button header navigation
         */
        function flexia_nav_logo_button($items)
        {
            $flexia_nav_login = flexia_get_option('flexia_enable_login_button');
            $flexia_nav_login_url = flexia_get_option('flexia_custom_login_url');
            $login_url = (empty($flexia_nav_login_url) ? esc_url(wp_login_url(get_permalink())) : esc_url($flexia_nav_login_url));
            $logout_url = wp_logout_url(home_url());
            $flexia_login_text = flexia_get_option('flexia_custom_login_text');
            $flexia_logout_text = flexia_get_option('flexia_custom_logout_text');
            $flexia_log_in_out_url = is_user_logged_in() ? $logout_url : $login_url;
            $flexia_log_in_out_text = is_user_logged_in() ? esc_html__($flexia_logout_text) : esc_html__($flexia_login_text);

            if ($flexia_nav_login == true) {
                $items .= '<li class="menu-item navbar-login-menu">';
                $items .= '<a href="' . $flexia_log_in_out_url . '">';
                $items .= '<button><svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve"> <path d="M437,75C388.7,26.6,324.4,0,256,0C187.6,0,123.3,26.6,75,75S0,187.6,0,256c0,68.4,26.6,132.7,75,181 c48.4,48.4,112.6,75,181,75c68.4,0,132.7-26.6,181-75c48.4-48.4,75-112.6,75-181C512,187.6,485.4,123.3,437,75z M184.8,224.8 c0-39.2,31.9-71.2,71.2-71.2c39.2,0,71.2,31.9,71.2,71.2c0,39.2-31.9,71.2-71.2,71.2C216.8,296,184.8,264.1,184.8,224.8z M256,340.6 c55.8,0,103.5,38.6,115.2,92.5c-34.3,22.4-74,34.2-115.2,34.2c-41.1,0-80.9-11.8-115.2-34.2C152.5,379.2,200.2,340.6,256,340.6z M365,338c-10.6-9.6-22.4-17.7-35-24.2c26.4-21.9,41.8-54.3,41.8-89c0-63.8-51.9-115.8-115.8-115.8c-63.8,0-115.8,51.9-115.8,115.8 c0,34.7,15.4,67.1,41.8,89c-12.7,6.5-24.4,14.6-35,24.2c-19.6,17.7-34.4,39.7-43.5,64.2C65.9,363,44.6,310.4,44.6,256 c0-116.6,94.8-211.4,211.4-211.4c116.6,0,211.4,94.8,211.4,211.4c0,54.4-21.3,107-58.9,146.2C399.4,377.7,384.6,355.7,365,338z"/> </svg> <span class="button-text">' . $flexia_log_in_out_text . '</span></button>';
                $items .= '</a></li>';
            }
            return $items;
        }
        add_filter('flexia_header_icon_items', 'flexia_nav_logo_button', 101, 1);

        /**
         * Enable support for Post Formats
         */
        add_theme_support('post-formats', array('aside', 'image', 'video', 'quote', 'link', 'status', 'chat'));

        /**
         * Enable support for WooCommerce
         */
        add_theme_support('woocommerce');

        /*
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
        add_theme_support('html5', array(
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
        ));

        // Set up the WordPress core custom background feature.
        add_theme_support('custom-background', apply_filters('flexia_custom_background_args', array(
            'default-color' => 'f9f9f9',
            'default-image' => '',
        )));

        // Add theme support for selective refresh for widgets.
        add_theme_support('customize-selective-refresh-widgets');

        /**
         * Add support for core custom logo.
         *
         * @link https://codex.wordpress.org/Theme_Logo
         */
        add_theme_support('custom-logo', array(
            'height' => 80,
            'width' => 250,
            'flex-width' => true,
            'flex-height' => true,
        ));

        /**
         * Register support for Gutenberg
         */
        add_theme_support('align-wide'); //Wide/Full Alignment


    }
}
add_action('after_setup_theme', 'flexia_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function flexia_content_width()
{
    $GLOBALS['content_width'] = apply_filters('flexia_content_width', 640);
}
add_action('after_setup_theme', 'flexia_content_width', 0);

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Styles and Scripts enqueues.
 */

require get_template_directory() . '/framework/functions/enqueue/styles.php';
require get_template_directory() . '/framework/functions/enqueue/scripts.php';

/**
 * Widgets.
 */

require get_template_directory() . '/framework/functions/flexia/widgets.php';

/**
 * Flexia Nav Walker.
 */

require get_template_directory() . '/framework/functions/flexia/flexia-edit-nav-menu-walker.php';
require get_template_directory() . '/framework/functions/flexia/flexia-extra-menu-field.php';
require get_template_directory() . '/framework/functions/flexia/flexia-nav-walker.php';

/**
 * Breadcrumbs.
 */

require get_template_directory() . '/framework/functions/flexia/breadcrumb.php';

/**
 * Functions to Add Templates throgh Hooks file
 */

require get_template_directory() . '/framework/functions/flexia/flexia-template-hooks.php';

/**
 * Functions to Add Helper Fuctions file
 */
require get_template_directory() . '/framework/functions/flexia/flexia-helper.php';

/**
 * Functions to Add Blog Template file
 */
require get_template_directory() . '/framework/functions/flexia/flexia-blog-templates.php';

/**
 * Integrations.
 */

if (class_exists('WooCommerce')) {
    require get_template_directory() . '/framework/functions/flexia/integrations/woocommerce/woocommerce-integration.php';
    require get_template_directory() . '/framework/functions/flexia/integrations/woocommerce/class-flexia-woocommerce.php';
}

if (class_exists('Easy_Digital_Downloads')) {
    require get_template_directory() . '/framework/functions/flexia/integrations/edd/edd-integration.php';
}

if (class_exists('\Elementor\Plugin')) {
    require get_template_directory() . '/framework/functions/flexia/integrations/elementor/class-elementor-pro.php';
}

/**
 * Customizer additions
 */

require get_template_directory() . '/framework/functions/customizer/defaults.php';
require get_template_directory() . '/framework/functions/customizer/customizer.php';

/**
 * Extend Customizer
 */
require get_template_directory() . '/framework/functions/customizer/customizer-extend/class-flexia-wp-customize-panel.php';
require get_template_directory() . '/framework/functions/customizer/customizer-extend/class-flexia-wp-customize-section.php';

/**
 * Requiring flexia metaboxes
 */
require_once get_template_directory() . '/admin/metabox/class-flexia-metaboxes-installer.php';
require_once get_template_directory() . '/admin/metabox/class-flexia-post-metaboxes-installer.php';

// Admin functionalities
if (is_admin()) {
    require_once get_template_directory() . '/admin/admin.php';

    new Flexia_Admin();
}

/**
 * Load Jetpack compatibility file.
 */
if (defined('JETPACK__VERSION')) {
    require get_template_directory() . '/inc/jetpack.php';
}

/********* Google Fonts URL function  ***********/

if (!function_exists('flexia_fonts_url')) {
    function flexia_fonts_url()
    {
        $fonts_url = '';
        $content_font = flexia_get_option('flexia_body_font_family');
        $content_font_variant = flexia_get_option('flexia_body_font_variants');
        $content_font_subset = flexia_get_option('flexia_body_font_subsets');

        $header_font = flexia_get_option('flexia_heading_font_family');
        $header_font_variant = flexia_get_option('flexia_heading_font_variants');
        $header_font_subset = flexia_get_option('flexia_heading_font_subsets');

        $paragraph_font = flexia_get_option('flexia_paragraph_font_family');
        $paragraph_font_variant = flexia_get_option('flexia_paragraph_font_variants');
        $paragraph_font_subset = flexia_get_option('flexia_paragraph_font_subsets');

        $link_font = flexia_get_option('flexia_link_font_family');
        $link_font_variant = flexia_get_option('flexia_link_font_variants');
        $link_font_subset = flexia_get_option('flexia_link_font_subsets');

        $button_font = flexia_get_option('flexia_button_font_family');
        $button_font_variant = flexia_get_option('flexia_button_font_variants');
        $button_font_subset = flexia_get_option('flexia_button_font_subsets');

        $blogHeader_title_font = flexia_get_option('flexia_blog_header_title_font_family');
        $blogHeader_desc_font = flexia_get_option('flexia_blog_header_desc_font_family');

        $archiveHeader_title_font = flexia_get_option('flexia_archive_header_title_font_family');
        $archiveHeader_desc_font = flexia_get_option('flexia_archive_header_desc_font_family');


        if ('off' !== $content_font || 'off' !== $header_font) {
            $font_families = array();

            if ('off' !== $content_font) {
                $font_families[] = $content_font . ':' . $content_font_variant . '&amp;' . $content_font_subset;
            }

            if ('off' !== $header_font) {
                $font_families[] = $header_font . ':' . $header_font_variant . '&amp;' . $header_font_subset;
            }

            if ('off' !== $paragraph_font) {
                $font_families[] = $paragraph_font . ':' . $paragraph_font_variant . '&amp;' . $paragraph_font_subset;
            }

            if ('off' !== $link_font) {
                $font_families[] = $link_font . ':' . $link_font_variant . '&amp;' . $link_font_subset;
            }

            if ('off' !== $button_font) {
                $font_families[] = $button_font . ':' . $button_font_variant . '&amp;' . $button_font_subset;
            }

            if ('off' !== $blogHeader_title_font) {
                $font_families[] = $blogHeader_title_font;
            }

            if ('off' !== $blogHeader_desc_font) {
                $font_families[] = $blogHeader_desc_font;
            }

            if ('off' !== $archiveHeader_title_font) {
                $font_families[] = $archiveHeader_title_font;
            }

            if ('off' !== $archiveHeader_desc_font) {
                $font_families[] = $archiveHeader_desc_font;
            }

            $query_args = array(
                'family' => urlencode(implode('|', array_unique($font_families))),
            );

            $fonts_url = add_query_arg($query_args, 'https://fonts.googleapis.com/css');
        }

        return esc_url_raw($fonts_url);
    }
    add_action('init', 'flexia_fonts_url');
}


// Mute admin notice
function flexia_nag_ignore()
{
    if (isset($_GET['flexia_nag_ignore']) && $_GET['flexia_nag_ignore'] == '0') {
        update_user_meta(get_current_user_id(), 'flexia_ignore_notice006', true);
    }
}
add_action('admin_init', 'flexia_nag_ignore');


/** 
 * This Function will be used for Showig Sidebar in page templates
 * @return HTML
 */
function flexia_sidebar_content($sidebar_id, $sidebar_position, $classes)
{
    ob_start();
    dynamic_sidebar($sidebar_id);
    $sidebar =  ob_get_clean();
    return '
	<aside id="' . $sidebar_position . '" class="flexia-sidebar ' . $sidebar_position . ' ' . $classes . '">
		<div class="flexia-sidebar-inner">
			' . $sidebar . '
		</div>
	</aside>';
}

/**
 * upgrader_process_complete
 */
function flexia_upgrader_process_complete($upgrader_object, $options)
{
    if ($options['action'] === 'update' && $options['type'] === 'theme') {
        foreach ($options['themes'] as $each_theme) {
            if ($each_theme === 'flexia') {
                $logobar_position = get_theme_mod('flexia_logobar_position');
                if ('flexia-logobar-stacked' === $logobar_position) {
                    set_theme_mod('flexia_header_layouts', 4);
                }
            }
        }
    }
}
add_action('upgrader_process_complete', 'flexia_upgrader_process_complete', 10, 2);


// Register Custom Role
add_role('basic_contributor', 'Basic Contributor', array(
    'read' => true, // True allows that capability
    'edit_posts' => true,
    'delete_posts' => false, // Use false to explicitly deny
));


add_action('admin_head', 'custom_admin_css');

function custom_admin_css( ){

$user_ID = get_current_user_id(); 
$user_meta = get_userdata($user_ID);
 $user_roles = $user_meta->roles;
if ( in_array( 'basic_contributor', (array) $user_roles[0] ) ) {
   
 
       
        echo '<style>
        div#woocommerce-layout__primary
        {
            display:none !important;
        }
        body{
            background: #fff !important;
            height: 100% !important;
        }
        div#wpfooter {
            display: none;
        }

        li#toplevel_page_woocommerce,li#toplevel_page_wc-reports, li#toplevel_page_woocommerce-marketing,li#toplevel_page_wc-admin-path--analytics-overview, li#toplevel_page_vc-general,li#menu-settings, li#toplevel_page_edit-post_type-acf-field-group,li#toplevel_page_TS_VCSC_Extender, li#menu-appearance, li#menu-tools{ 
             display: none; 
         } 

        .components-surface.components-card.woocommerce-store-alerts.is-alert-update.css-1pd4mph.e19lxcc00 {
            display: none;
        }

        li.product_options_for_woocommerce_options.product_options_for_woocommerce_tab {
            display: none !important;
        }

     
      #wpadminbar #wp-admin-bar-wp-logo>.ab-item  {
          display: none !important;
      }
      li#wp-admin-bar-new-content{
           display: none !important;
      }
      li#wp-admin-bar-archive{
           display: none !important;
      }

    .wrap h1.wp-heading-inline {
        display: none !important;
    }
    .wrap .wp-heading-inline+.page-title-action {
        
        display: none  !important;
    }
    ul.subsubsub {
        display: none !important;
    }
    .woocommerce-layout__header .woocommerce-layout__header-wrapper {
        display: none !important;
    }

    .notice{
        display: none !important;
    }

    div#adminmenumain {
        display: none !important;
    }

    div#wpcontent {
        margin-left: 0px !important;
}
div#wpadminbar {
    display: none !important;
}
div#mw_adminimize_admin_bar {
    display: none;
}

   
        </style>';
   
    
}
}

add_filter( 'woocommerce_product_data_tabs', 'custom_product_data_tabs' ); 
function custom_product_data_tabs( $tabs ) {
        
    $user_ID = get_current_user_id(); 
    $user_meta = get_userdata($user_ID);
    $user_roles = $user_meta->roles;

    if ( in_array( 'basic_contributor', (array) $user_roles[0] ) ) {
      unset( $tabs['inventory'] );
      unset( $tabs['shipping'] );
      unset( $tabs['linked_product'] );
      unset( $tabs['advanced'] );
    }
    return $tabs;
}


// Send Email to users who joins the waitlist
add_filter( 'woocommerce_email_subject_woocommerce_waitlist_signup_email', 'send_email_waitlist_join' );
function send_email_waitlist_join() { 
     // COMPILE WP MAIL
      $current_user = wp_get_current_user();
      $user_email =  $current_user->user_email;

     $name = $current_user->display_name ;

    
     $email_content = '<table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
     <tbody><tr>
     <td align="center" valign="top">
                             <div id="m_-2035736652434526627template_header_image">
                                 <p style="margin-top:0"><img src="https://ci4.googleusercontent.com/proxy/4pz0MLYxQHCesb-klWIzVKYgb3bX2IflHc9YZlPQCxrJaFM_UTeRs0EK_M8LEyxG1P91ojsWimrOEPMDFgX1A_h1_sSj-AGnX2ZDDnKueZXMvgsU4UUUB9Crt_H9S-BKlKj9ier2=s0-d-e1-ft#https://demo.runnerscamp.org/wp-content/uploads/2021/11/RCI-Final-22.png" alt="Runners Camp" style="border:none;display:inline-block;font-size:14px;font-weight:bold;height:auto;outline:none;text-decoration:none;text-transform:capitalize;vertical-align:middle;max-width:100%;margin-left:0;margin-right:0" border="0" class="CToWUd" data-bit="iit"></p>						</div><table border="0" cellpadding="0" cellspacing="0" width="600" id="m_-2035736652434526627template_container" style="background-color:#fff;border:1px solid #e4e4e4;border-radius:3px" bgcolor="#fff"><tbody><tr><td align="center" valign="top">
                                         
                                         <table border="0" cellpadding="0" cellspacing="0" width="100%" id="m_-2035736652434526627template_header" style="background-color:#3e69c5;color:#fff;border-bottom:0;font-weight:bold;line-height:100%;vertical-align:middle;font-family:&quot;Helvetica Neue&quot;,Helvetica,Roboto,Arial,sans-serif;border-radius:3px 3px 0 0" bgcolor="#3e69c5"><tbody><tr>
     <td id="m_-2035736652434526627header_wrapper" style="padding:36px 48px;display:block">
                                                     <h1 style="font-family:&quot;Helvetica Neue&quot;,Helvetica,Roboto,Arial,sans-serif;font-size:30px;font-weight:300;line-height:150%;margin:0;text-align:left;color:#fff;background-color:inherit" bgcolor="inherit">Welcome</h1>
                                                 </td>
                                             </tr></tbody></table>
     
     </td>
                                 </tr>
     <tr>
     <td align="center" valign="top">
                                         
                                         <table border="0" cellpadding="0" cellspacing="0" width="600" id="m_-2035736652434526627template_body"><tbody><tr>
     <td valign="top" id="m_-2035736652434526627body_content" style="background-color:#fff" bgcolor="#fff">
                                                     
                                                     <table border="0" cellpadding="20" cellspacing="0" width="100%"><tbody><tr>
     <td valign="top" style="padding:48px 48px 32px">
                                                                 <div id="m_-2035736652434526627body_content_inner" style="color:#858585;font-family:&quot;Helvetica Neue&quot;,Helvetica,Roboto,Arial,sans-serif;font-size:14px;line-height:150%;text-align:left" align="left"><span class="im">
     <p style="margin:0 0 16px">Hi There,</p>
     
     <p style="margin:0 0 16px">
    You has just signed up to the waitlist</p>
    
     
     </span></div></td> </tr></tbody></table> </td>  </tr></tbody></table> </td>     </tr>    </tbody></table>   </td>  </tr>
     <tr>
     <td align="center" valign="top">
                             
                             <table border="0" cellpadding="10" cellspacing="0" width="600" id="m_-2035736652434526627template_footer"><tbody><tr>
     <td valign="top" style="padding:0;border-radius:6px">
                                         <table border="0" cellpadding="10" cellspacing="0" width="100%"><tbody><tr>
     <td colspan="2" valign="middle" id="m_-2035736652434526627credit" style="border-radius:6px;border:0;color:#a3a3a3;font-family:&quot;Helvetica Neue&quot;,Helvetica,Roboto,Arial,sans-serif;font-size:12px;line-height:150%;text-align:center;padding:24px 0" align="center">
                                                     <p style="margin:0 0 16px">Runners Camp International</p>
                                                 </td>
                                             </tr></tbody></table>
     </td>
                                 </tr></tbody></table>
     
     </td>
                     </tr>
     </tbody></table>';

     $subject = 'Join waitlist';

     $headers[] = 'Content-Type: text/html; charset=UTF-8';
     $headers[] = 'From: Runners Camp <admin@runerscamp.staging-server.online>';
     $headers[] = 'Reply-To: Runners Camp  <admin@runerscamp.staging-server.online>';
     
     
     $email_status = wp_mail( $user_email , $subject, $email_content, $headers );
     return __( 'Runners Camp' );
 
}

// Remove product from cart if it is out of stock
function ced_out_of_stock_products() {
    if ( WC()->cart->is_empty() ) {
        return;
    }
 
    $removed_products = [];
 
    foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
        $product_obj = $cart_item['data'];
 
        if ( ! $product_obj->is_in_stock() ) {
            WC()->cart->remove_cart_item( $cart_item_key );
            $removed_products[] = $product_obj;
        }
    }
 
    if (!empty($removed_products)) {
        wc_clear_notices(); 
 
        foreach ( $removed_products as $idx => $product_obj ) {
            $product_name = $product_obj->get_title();

            //your notice here
            $msg = sprintf( __( "The product '%s' was removed from your cart because it is out of stock.", 'woocommerce' ), $product_name);
 
            wc_add_notice( $msg, 'error' );
        }
    }
 
}



// Shortcode for contact information
function rc_contact_information_shortcode() { 
  
    $contact_information = get_option( 'rc_website_content' );
    // Things that you want to do.
    $content = "<h3 class='rc-title'>Have Questions?</h3>";
    $content .= '<div class="rc-contact-info">'.wp_kses_post($contact_information).'</div>';
   // $content .= wp_kses_data($contact_information);
      
    // Output needs to be return
    return $content;
    }
    // register shortcode
    add_shortcode('rc_contact_information', 'rc_contact_information_shortcode');


    // Shortcode for training camp dates
function rc_training_campdates_shortcode() { 
  
    $traning_camp_dates = get_option( 'rc_camp_available_dates' );
    // Things that you want to do.
    
    $content = '<div class="rc-contact-info">'.wp_kses_post($traning_camp_dates).'</div>';
   // $content .= wp_kses_data($contact_information);
      
    // Output needs to be return
    return $content;
    }
    // register shortcode
    add_shortcode('rc_traning_camp_dates', 'rc_training_campdates_shortcode');

    // Shortcode for sitename
    function rc_sitename_shortcode() { 
  
        // Things that you want to do.
        $content = "<h3 class='rc-title'>Website</h3>";
        $content .= '<div class="rc-sitename">'.get_bloginfo( 'name' ).'</div>';
          
        // Output needs to be return
        return $content;
        }
        // register shortcode
        add_shortcode('rc_sitename', 'rc_sitename_shortcode');


         // Shortcode for Price and discounted rates
    function rc_rates_shortcode() { 
       
        // Things that you want to do.
        $rates = get_option( 'rc_discounts' );
       
        $data = (array) $rates;

       $multicamp =  $data["multicamp"];
       $multicamper =  $data["multicamper"];

       $earlybird_value =  $data["earlybird_value"];
       $earlybird_ends =  $data["earlybird_ends"];

       $sleepybird_value =  $data["sleepybird_value"];
       $sleepybird_ends =  $data["sleepybird_ends"];

           $content = "<div class='rc-container'>";

           $content .= "<h3 class='rc-title'>Discounts</h3>";
           $content .= "<h4>Multi-Camp Discount</h4>";
           $content .= "<h5 class='rc-desc'> This is a flat discount applied if both camps are represented in the cart during checkout. </h5>"; 
           $content .= "<p class='rc-rates'>Discount amount: $multicamp </p>"; 

           $content .= "<h4>Multi-Camper Discount</h4>";
           $content .= "<h5 class='rc-desc'>This is a per-camper discount applied after at least two campers have been registered. Campers are distinguished based on their first and last names.</h5>"; 
           $content .= "<p class='rc-rates'>Discount amount: $multicamper </p>"; 

           $content .= "<h4>Earlybird Discount</h4>";
           $content .= "<h5 class='rc-desc'>This discount is applied to every registration sold before the given date.</h5>"; 
           $content .= "<p class='rc-rates'>Discount amount: $earlybird_value </p>"; 
           $content .= "<p class='rc-dates'>Last day of discount: $earlybird_ends </p>"; 


           $content .= "<h4>Sleepybird Discount</h4>";
           $content .= "<h5 class='rc-desc'>This discount is applied to every registration sold before the given date. If enabled, the sleepybird discount begins the day after the earlybird discount ends.</h5>"; 
           $content .= "<p class='rc-rates'>Discount amount: $sleepybird_value </p>"; 
           $content .= "<p class='rc-dates'>Last day of discount: $sleepybird_ends </p>"; 

           $content .= '</div>';
      
        // Output needs to be return
        return $content;
        }
        // register shortcode
        add_shortcode('rc_rates', 'rc_rates_shortcode');
    



  // Shortcode for Location/Map Camp1
  function rc_camp_loc_camp1_shortcode() { 
  
    // Things that you want to do.
    $rc_camp_1 = get_option( 'rc_camp_1' );
  


   
    $content = "<div class='rc-map-container'>";
    $content .= $rc_camp_1;
    $content .= "<h4>Camp 1</h4>";

    $content .= '</div>';
    // Output needs to be return
    return $content;
    }
    // register shortcode
    add_shortcode('rc_location_map_camp1', 'rc_camp_loc_camp1_shortcode');


    // Shortcode for Location/Map Camp2
  function rc_camp_loc_camp2_shortcode() { 
  
    // Things that you want to do.
   
    $rc_camp_2 = get_option( 'rc_camp_2' );


    
    $content = "<div class='rc-map-container'>";
    $content .= "<div class='rc-col'><iframe src='$rc_camp_2' width='400' height='250' style='border:0;' allowfullscreen='' loading='lazy'></iframe>";
    $content .= "<h4>Camp 2</h4></div>";


    $content .= '</div>';
    // Output needs to be return
    return $content;
    }
    // register shortcode
    add_shortcode('rc_location_map_camp2', 'rc_camp_loc_camp2_shortcode');


    // Shortcode for Location/Map Camp3
  function rc_camp_loc_camp3_shortcode() { 
  
    // Things that you want to do.
   
    $rc_camp_3 = get_option( 'rc_camp_3' );


    
    $content = "<div class='rc-map-container'>";
    $content .= "<div class='rc-col'><iframe src='$rc_camp_3' width='400' height='250' style='border:0;' allowfullscreen='' loading='lazy'></iframe>";
    $content .= "<h4>Camp 3</h4></div>";


    $content .= '</div>';
    // Output needs to be return
    return $content;
    }
    // register shortcode
    add_shortcode('rc_location_map_camp3', 'rc_camp_loc_camp3_shortcode');




  // Shortcode for Camp1 Name 
  function rc_camp1_name_shortcode() { 
  
    // Things that you want to do.
    $campname_1 = get_option( 'rc_camp_name_1' );
  

    $content = "<div class='rc-addr-container'>";

    // $content .= "<h3 class='rc-title'>Locations</h3>";
    $content .= "<div class='rc-addr-col'><h4>$campname_1</h4></div>";
  
    $content .= '</div>';
    // Output needs to be return
    return $content;
    }
    // register shortcode
    add_shortcode('rc_camp1_name', 'rc_camp1_name_shortcode');


    // Shortcode for Camp1 Address
  function rc_camp1_addr_shortcode() { 
  
    // Things that you want to do.
    
    $campaddress_1 = get_option( 'rc_camp_address_1' );
   

    $content = "<div class='rc-addr-container'>";

    $content .= "<div class='rc-addr'>$campaddress_1</div>";

    $content .= '</div>';
    // Output needs to be return
    return $content;
    }
    // register shortcode
    add_shortcode('rc_camp1_address', 'rc_camp1_addr_shortcode');


    // Shortcode for Camp2 Name 
  function rc_camp2_name_shortcode() { 
  
    // Things that you want to do.
   
    $campname_2 = get_option( 'rc_camp_name_2' );
    

    $content = "<div class='rc-addr-container'>";

    // $content .= "<h3 class='rc-title'>Locations</h3>";
    $content .= "<div class='rc-addr-col'><h4>$campname_2</h4></div>";
   

    $content .= '</div>';
    // Output needs to be return
    return $content;
    }
    // register shortcode
    add_shortcode('rc_camp2_name', 'rc_camp2_name_shortcode');

    // Shortcode for Camp2 Address 
  function rc_camp2_addr_shortcode() { 
  
    // Things that you want to do.

    $campaddress_2 = get_option( 'rc_camp_address_2' );

    $content = "<div class='rc-addr-container'>";

    // $content .= "<h3 class='rc-title'>Locations</h3>";
   
    $content .= "<div class='rc-addr'>$campaddress_2</div>";
   

    $content .= '</div>';
    // Output needs to be return
    return $content;
    }
    // register shortcode
    add_shortcode('rc_camp2_address', 'rc_camp2_addr_shortcode');



   
    // Shortcode for Camp3 Name 
  function rc_camp3_name_shortcode() { 
  
    // Things that you want to do.
   
    $campname_3 = get_option( 'rc_camp_name_3' );
    

    $content = "<div class='rc-addr-container'>";

    // $content .= "<h3 class='rc-title'>Locations</h3>";
    $content .= "<div class='rc-addr-col'><h4>$campname_3</h4></div>";
   

    $content .= '</div>';
    // Output needs to be return
    return $content;
    }
    // register shortcode
    add_shortcode('rc_camp3_name', 'rc_camp3_name_shortcode');

    // Shortcode for Camp3 Address 
  function rc_camp3_addr_shortcode() { 
  
    // Things that you want to do.

    $campaddress_3 = get_option( 'rc_camp_address_3' );

    $content = "<div class='rc-addr-container'>";

    // $content .= "<h3 class='rc-title'>Locations</h3>";
   
    $content .= "<div class='rc-addr'>$campaddress_3</div>";
   

    $content .= '</div>';
    // Output needs to be return
    return $content;
    }
    // register shortcode
    add_shortcode('rc_camp3_address', 'rc_camp3_addr_shortcode');
    

//Shortocde for camp name and camp dates
function rc_camp_dates_shortcode() { 
  
    // Things that you want to do.
    $rc_camps = get_option( 'rc_camps', [] );

    $camp1 = $rc_camps['camp1_name'];
    $camp2 = $rc_camps['camp2_name'];
   

    $content = "<h3 class='rc-title'>Camp Dates</h3>";
    $content .= "<b>Camp 1: </b> $camp1";
    $content .= "<br/><b>Camp 2: </b> $camp2";
   // $content .= "<div class='rc-camp-container'>";
   // $content .= "<div class='rc-col'>$camp1";
   // $content .= "<h4>Camp 1</h4></div>";


    //$content .= "<div class='rc-col'>$camp2";
   // $content .= "<h4>Camp 2</h4></div>";


   // $content .= '</div>';
    // Output needs to be return
    return $content;
    }
    // register shortcode
    add_shortcode('rc_camp_dates', 'rc_camp_dates_shortcode');


    //Shortocde for camp Track Meet 1 Title
function rc_camp_trackmeet1_title_shortcode() { 
  
    // Things that you want to do.
    $events = get_option( 'rc_events', [] );
    $title_meet1 = $events['meet1_title'];
   
if($title_meet1){
   // $content = "<h3 class='rc-title'>Camp Track Meet 1</h3>";
    $content = "<b>Title: </b> $title_meet1";
    // Output needs to be return
    return $content;
}
  
    }
    // register shortcode
    add_shortcode('rc_camp_title_meet1', 'rc_camp_trackmeet1_title_shortcode');


     //Shortocde for camp Track Meet 1 description
function rc_camp_trackmeet1_desc_shortcode() { 
  
    // Things that you want to do.
    $events = get_option( 'rc_events', [] );
    $events_meet1 = $events['meet1_events'];
   
if($events_meet1){
    //$content = "<h3 class='rc-title'>Camp Track Meet</h3>";
    $content = "<br/><b>Events: </b> $events_meet1";
    // Output needs to be return
    return $content;
}
  
    }
    // register shortcode
    add_shortcode('rc_camp_events_meet1', 'rc_camp_trackmeet1_desc_shortcode');


     //Shortocde for camp Track Meet 1 pages
function rc_camp_trackmeet1_pagenumber_shortcode() { 
  
    // Things that you want to do.
    $events = get_option( 'rc_events', [] );
    $meet1_maxpage = $events['meet1_max'];
   
if($meet1_maxpage){
    //$content = "<h3 class='rc-title'>Camp Track Meet</h3>";
    $content = "<br/><b>Max events per camper: </b> $meet1_maxpage";
    // Output needs to be return
    return $content;
}
  
    }
    // register shortcode
    add_shortcode('rc_camp_maxeventspercamper_meet1', 'rc_camp_trackmeet1_pagenumber_shortcode');




        //Shortocde for camp Track Meet 2 Title
function rc_camp_trackmeet2_title_shortcode() { 
  
    // Things that you want to do.
    $events = get_option( 'rc_events', [] );
    $title_meet2 = $events['meet2_title'];
   
if($title_meet2){
   // $content = "<h3 class='rc-title'>Camp Track Meet 2</h3>";
    $content = "<b>Title: </b> $title_meet2";
    // Output needs to be return
    return $content;
}
  
    }
    // register shortcode
    add_shortcode('rc_camp_title_meet2', 'rc_camp_trackmeet2_title_shortcode');


      //Shortocde for camp Track Meet 2 description
function rc_camp_trackmeet2_desc_shortcode() { 
  
    // Things that you want to do.
    $events = get_option( 'rc_events', [] );
    $events_meet2 = $events['meet2_events'];
   
if($events_meet2){
    //$content = "<h3 class='rc-title'>Camp Track Meet</h3>";
    $content = "<br/><b>Events: </b> $events_meet2";
    // Output needs to be return
    return $content;
}
  
    }
    // register shortcode
    add_shortcode('rc_camp_events_meet2', 'rc_camp_trackmeet2_desc_shortcode');


      //Shortocde for camp Track Meet 2 pages
function rc_camp_trackmeet2_pagenumber_shortcode() { 
  
    // Things that you want to do.
    $events = get_option( 'rc_events', [] );
    $meet2_maxpage = $events['meet2_max'];
   
if($meet2_maxpage){
    //$content = "<h3 class='rc-title'>Camp Track Meet</h3>";
    $content = "<br/><b>Max events per camper: </b> $meet2_maxpage";
    // Output needs to be return
    return $content;
}
  
    }
    // register shortcode
    add_shortcode('rc_camp_maxeventspercamper_meet2', 'rc_camp_trackmeet2_pagenumber_shortcode');
