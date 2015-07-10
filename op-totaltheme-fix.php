<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * Dashboard. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://www.optimizepress.com/
 * @since             1.0.0
 * @package           Op_TotalTheme_Fix
 *
 * @wordpress-plugin
 * Plugin Name:       OptimizePress Total Theme fix
 * Plugin URI:        http://www.optimizepress.com/
 * Description:       Allows LiveEditor to work with Total theme
 * Version:           1.0.0
 * Author:            OptimizePress
 * Author URI:        http://www.optimizepress.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       op-totaltheme-fix
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( !function_exists( 'wpex_responsive_widths' ) ) {
    function wpex_responsive_widths() {

        $css ='';

        /**
        Tablet Portrait
         **/

        // Tablet Widths
        $tablet_landscape_main_container_width = wpex_option( 'tablet_landscape_main_container_width' );
        $tablet_landscape_main_container_width = ( '980px' != $tablet_landscape_main_container_width ) ? $tablet_landscape_main_container_width : '';

        $tablet_landscape_left_container_width = wpex_option( 'tablet_landscape_left_container_width' );
        $tablet_landscape_left_container_width = ( '680px' != $tablet_landscape_left_container_width ) ? $tablet_landscape_left_container_width : '';

        $tablet_landscape_sidebar_width = wpex_option( 'tablet_landscape_sidebar_width' );
        $tablet_landscape_sidebar_width = ( '250px' != $tablet_landscape_sidebar_width ) ? $tablet_landscape_sidebar_width : '';

        if ( $tablet_landscape_main_container_width || $tablet_landscape_left_container_width || $tablet_landscape_sidebar_width ) {

            $css .= '@media only screen and (min-width: 960px) and (max-width: 1280px) {';

            if ( $tablet_landscape_main_container_width ) {
                $css .= '.container { width: '. $tablet_landscape_main_container_width .'; }';
            }

            if ( $tablet_landscape_left_container_width ) {
                $css .= '.content-area { width: '. $tablet_landscape_left_container_width .' !important; }';
            }

            if ( $tablet_landscape_sidebar_width ) {
                $css .= '#sidebar { width: '. $tablet_landscape_sidebar_width .' !important; }';
            }

            $css .= '}';

        }

        /**
        Tablet Portrait
         **/

        // Tablet Widths
        $tablet_main_container_width = wpex_option( 'tablet_main_container_width' );
        $tablet_main_container_width = ( '700px' != $tablet_main_container_width ) ? $tablet_main_container_width : '';

        $tablet_left_container_width = wpex_option( 'tablet_left_container_width' );
        $tablet_left_container_width = ( '100%' != $tablet_left_container_width ) ? $tablet_left_container_width : '';

        $tablet_sidebar_width = wpex_option( 'tablet_sidebar_width' );
        $tablet_sidebar_width = ( '100%' != $tablet_sidebar_width ) ? $tablet_sidebar_width : '';

        if ( $tablet_main_container_width || $tablet_left_container_width || $tablet_sidebar_width ) {

            $css .= '@media only screen and (min-width: 768px) and (max-width: 959px) {';

            if ( $tablet_main_container_width ) {
                $css .= '.container, .wpb_row .wpb_row, .vc_row-fluid.container { width: '. $tablet_main_container_width .'; }';
            }

            if ( $tablet_left_container_width ) {
                $css .= '.content-area { width: '. $tablet_left_container_width .' !important; }';
            }

            if ( $tablet_sidebar_width ) {
                $css .= '#sidebar { width: '. $tablet_sidebar_width .' !important; }';
            }

            $css .= '}';

        }

        /**
        Phone Size
         **/

        // Phone Portrait
        $mobile_portrait_main_container_width = wpex_option( 'mobile_portrait_main_container_width' );
        if ( $mobile_portrait_main_container_width && '90%' != $mobile_portrait_main_container_width  ) {
            $css .= '@media only screen and (max-width: 767px) {
				.container { width: '. $mobile_portrait_main_container_width .' !important; min-width: 0; }
			}';
        }

        // Phone Landscape
        $mobile_landscape_main_container_width = wpex_option( 'mobile_landscape_main_container_width' );
        if ( $mobile_landscape_main_container_width && '90%' != $mobile_landscape_main_container_width ) {
            $css .= '@media only screen and (min-width: 480px) and (max-width: 767px) {
				.container { width: '. $mobile_landscape_main_container_width .' !important; }
			}';
        }

        /**
        Output
         **/

        // Return custon CSS
        if ( '' != $css && !empty($css) ) {
            $css =  preg_replace( '/\s+/', ' ', $css );
            $css = '/*Responsive Widths CSS START*/'. $css .'/*Responsive Widths CSS END*/';
            return $css;
        } else {
            return '';
        }

    }
}

if ( !function_exists( 'wpex_custom_css' ) ) {
    function wpex_custom_css() {
        $css = wpex_option( 'custom_css' );
        if ( '' != $css && !empty($css) ) {
            return $css = '/*Admin Custom CSS START*/'. $css .'/*Admin Custom CSS END*/';
        } else {
            return '';
        }
    }
}

if ( !function_exists('wpex_body_classes') ) {
    function wpex_body_classes( $classes ) {

        // WPExplorer class
        $classes[] = 'wpex-theme';

        // Responsive
        $responsive = wpex_option('responsive','1');
        if ( $responsive == '1' ) {
            $classes[] = 'wpex-responsive';
        }

        // Add skin to body classes
        if ( function_exists( 'wpex_active_skin') ) {
            $site_theme = wpex_active_skin();
            if ( $site_theme ) {
                $classes[] = 'theme-'. $site_theme;
            }
        }

        // Page with Slider or header
        if ( is_singular() ) {
            global $post;
            $post_id = $post->ID;
            $slider = get_post_meta( $post_id, 'wpex_post_slider_shortcode', true );
            $title_style = get_post_meta( $post_id, 'wpex_post_title_style', true );
            if ( $slider ) {
                $classes[] = 'page-with-slider';
            }
            if ( $title_style == 'background-image' ) {
                $classes[] = 'page-with-background-title';
            }
        }

        // Layout Style
        if ( is_singular() ) {
            global $post;
            $meta = get_post_meta($post->ID, 'wpex_main_layout', true);
            if ( $meta == 'boxed' ) {
                $classes[] = $meta .'-main-layout';
            } else {
                $classes[] = wpex_option( 'main_layout_style', 'full-width') .'-main-layout';
            }
        } else {
            $classes[] = wpex_option( 'main_layout_style', 'full-width') .'-main-layout';
        }

        // Remove header bottom margin
        if ( is_singular() ) {
            global $post;
            $disable_header_margin = get_post_meta($post->ID, 'wpex_disable_header_margin', true);
            if ( 'on' == $disable_header_margin ) {
                $classes[] = 'no-header-margin';
            }
        }

        // Check if breadcrumbs are enabled
        if (function_exists('wpex_breadcrumbs_enabled')){
            if ( wpex_breadcrumbs_enabled() && 'default' == wpex_option( 'breadcrumbs_position', 'default' ) ) {
                $classes[] = 'has-breadcrumbs';
            }
        }


        // Shrink fixed header
        if ( wpex_option( 'shink_fixed_header', '1' ) && 'one' == wpex_option( 'header_style', '1' ) ) {
            $classes[] = 'shrink-fixed-header';
        }

        // Single Post cagegories
        if ( is_singular( 'post' ) ) {
            global $post;
            $cats = get_the_category($post->ID);
            foreach ( $cats as $c ) {
                $classes[] = 'post-in-category-'. $c->category_nicename;
            }
        }

        // WooCommerce
        if ( class_exists('Woocommerce') ) {
            if ( wpex_option( 'woo_shop_slider' ) !== '' && is_shop() ) {
                $classes[] = 'page-with-slider';
            }
            if ( wpex_option( 'woo_shop_title', '1' ) !== '1' && is_shop() ) {
                $classes[] = 'page-without-title';
            }
        }

        // Widget Icons
        if ( wpex_option('widget_icons', '1' ) == '1' ) {
            $classes[] = 'sidebar-widget-icons';
        }

        // Mobile
        if ( wp_is_mobile() ) {
            $classes[] = 'is-mobile';
        }

        return $classes;
    }
}