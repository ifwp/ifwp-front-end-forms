<?php
/*
Author: Improvements and fixes for WordPress
Author URI: https://github.com/ifwp/ifwp
Description: Improvements and fixes for FacetWP, Contact Form 7 and Meta Box front-end forms.
Domain Path:
License: GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Network:
Plugin Name: IFWP Front-end Forms
Plugin URI: https://github.com/ifwp/ifwp-front-end-forms
Text Domain: ifwp-front-end-forms
Version: 0.1.29
*/

if(defined('ABSPATH')){
    add_action('wp_enqueue_scripts', function(){
        wp_enqueue_style('ifwp-floating-labels-b4', plugin_dir_url(__FILE__) . 'ifwp-floating-labels-b4.css', [], filemtime(plugin_dir_path(__FILE__) . 'ifwp-floating-labels-b4.css'));
        wp_enqueue_script('ifwp-floating-labels-b4', plugin_dir_url(__FILE__) . 'ifwp-floating-labels-b4.js', ['jquery'], filemtime(plugin_dir_path(__FILE__) . 'ifwp-floating-labels-b4.js'), true);
    });
    add_action('plugins_loaded', function(){
        if(!class_exists('Puc_v4_Factory')){
			require_once(plugin_dir_path(__FILE__) . 'plugin-update-checker-4.10/plugin-update-checker.php');
		}
        Puc_v4_Factory::buildUpdateChecker('https://github.com/ifwp/ifwp-front-end-forms', __FILE__, 'ifwp-front-end-forms');
        if(!class_exists('simple_html_dom')){
            require_once(plugin_dir_path(__FILE__) . 'simple-html-dom-1.9.1/simple_html_dom.php');
		}
        require_once(plugin_dir_path(__FILE__) . 'mb/ifwp-mb-b4.php');
    });
}
