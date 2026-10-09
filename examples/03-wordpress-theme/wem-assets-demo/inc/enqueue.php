<?php
/**
 * Central front-end asset registration and conditional loading.
 * The example deliberately has no bundler or third-party JS libraries.
 */

if (!defined('ABSPATH')) {
    exit;
}

/** Return file modification time for cache busting in this demo. */
function wem_assets_version(string $relative): string {
    $path = get_theme_file_path($relative);
    return file_exists($path) ? (string) filemtime($path) : '1.0.0';
}

add_action('wp_enqueue_scripts', function () {
    // Shared assets on every front-end page.
    wp_enqueue_style(
        'wem-common-style',
        get_theme_file_uri('assets/css/common.css'),
        [],
        wem_assets_version('assets/css/common.css')
    );

    wp_enqueue_script(
        'wem-common-script',
        get_theme_file_uri('assets/js/common.js'),
        [],
        wem_assets_version('assets/js/common.js'),
        ['in_footer' => true, 'strategy' => 'defer']
    );

    // Home-specific assets.
    if (is_front_page()) {
        wp_enqueue_style(
            'wem-home-style',
            get_theme_file_uri('assets/css/pages/home.css'),
            ['wem-common-style'],
            wem_assets_version('assets/css/pages/home.css')
        );

        wp_enqueue_script(
            'wem-home-script',
            get_theme_file_uri('assets/js/pages/home.js'),
            ['wem-common-script'],
            wem_assets_version('assets/js/pages/home.js'),
            ['in_footer' => true, 'strategy' => 'defer']
        );
    }

    // Products page-specific assets.
    if (is_page('products')) {
        wp_enqueue_style(
            'wem-products-style',
            get_theme_file_uri('assets/css/pages/products.css'),
            ['wem-common-style'],
            wem_assets_version('assets/css/pages/products.css')
        );

        wp_enqueue_script(
            'wem-products-script',
            get_theme_file_uri('assets/js/pages/products.js'),
            ['wem-common-script'],
            wem_assets_version('assets/js/pages/products.js'),
            ['in_footer' => true, 'strategy' => 'defer']
        );
    }

    // Contact page-specific assets.
    if (is_page('contact')) {
        wp_enqueue_style(
            'wem-contact-style',
            get_theme_file_uri('assets/css/pages/contact.css'),
            ['wem-common-style'],
            wem_assets_version('assets/css/pages/contact.css')
        );

        wp_enqueue_script(
            'wem-contact-script',
            get_theme_file_uri('assets/js/pages/contact.js'),
            ['wem-common-script'],
            wem_assets_version('assets/js/pages/contact.js'),
            ['in_footer' => true, 'strategy' => 'defer']
        );
    }
});
