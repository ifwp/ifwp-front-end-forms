<?php

require_once(plugin_dir_path(__FILE__) . 'class-ifwp-mb-b4.php');
add_action('rwmb_enqueue_scripts', ['IFWP_MB_B4', 'enqueue_scripts']);
add_action('rwmb_frontend_after_submit_button', ['IFWP_MB_B4', 'after_submit_button']);
add_action('rwmb_frontend_before_submit_button', ['IFWP_MB_B4', 'before_submit_button']);
add_filter('rwmb_normalize_field', ['IFWP_MB_B4', 'normalize_field']);
add_filter('rwmb_outer_html', ['IFWP_MB_B4', 'outer_html'], 10, 2);
