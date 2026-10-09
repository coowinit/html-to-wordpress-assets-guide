<?php
/**
 * Theme bootstrap for the classic-theme demonstration.
 */

if (!defined('ABSPATH')) {
    exit;
}

add_action('after_setup_theme', function () {
    add_theme_support('title-tag');
});

require_once get_theme_file_path('inc/enqueue.php');
