<?php

/**
 * Add and active theme features
 */
require_once(get_template_directory() . '/inc/functions/active-features.php');

/**
 * Add Sidebar to theme
 */
require_once(get_template_directory() . '/inc/functions/sidebar.php');

/**
 * Load Custom widgets
 * 
 */
require_once(get_template_directory() . '/inc/widget/i8_show_posts_pro/i8_show_posts_pro.php');
require_once(get_template_directory() . '/inc/widget/i8_show_posts_two_col.php');
require_once(get_template_directory() . '/inc/widget/i8_site_info_box.php');
require_once(get_template_directory() . '/inc/widget/i8_menu.php');

/**
 *  helper functions 
 */
require_once(get_template_directory() . '/inc/functions/helper-functions.php');

/**
 *  Customize theme options
 */
require_once(get_template_directory() . '/inc/functions/theme-options/general_setting.php');
require_once(get_template_directory() . '/inc/functions/theme-options/theme_color_pallets.php');
require_once(get_template_directory() . '/inc/functions/theme-options/theme_copy_write.php');
require_once(get_template_directory() . '/inc/functions/theme-options/inline_ads/theme_inline_ads.php');
require_once(get_template_directory() . '/inc/functions/theme-options/theme_custom_scripts.php');
require_once(get_template_directory() . '/inc/functions/theme-options/theme_footer.php');
require_once(get_template_directory() . '/inc/functions/theme-options/theme_search.php');


/**
 * Change Excerpt limit characters
 */
function custom_excerpt_length($length)
{
    return 350;
}
add_filter('excerpt_length', 'custom_excerpt_length');


/**
 * Custom Term Field
 * 
 */
require_once(get_template_directory() . '/inc/functions/i8_CustomTermField.php');