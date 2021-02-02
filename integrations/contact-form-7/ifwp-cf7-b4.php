<?php

require_once(plugin_dir_path(__FILE__) . 'class-ifwp-cf7-b4.php');
remove_action('wpcf7_init', 'wpcf7_add_form_tag_select');
remove_action('wpcf7_init', 'wpcf7_add_form_tag_text');
remove_action('wpcf7_init', 'wpcf7_add_form_tag_textarea');
add_action('wp_enqueue_scripts', ['IFWP_CF7_B4', 'enqueue_scripts']);
add_action('wpcf7_init', ['IFWP_CF7_B4', 'init'], 10, 0);
add_filter('wpcf7_autop_or_not', '__return_false');
