<?php

/**
 * 
 * generate custom thumbnail tag 
 */
function i8_the_thumbnail($size_name, $class = '',  $dimension = array("width" => 70, "height" => 70), $default_img = true, $style = '', $lazy_load = true, $decoding_async = false)
{
    $default_thumbnail_url = get_template_directory_uri() . '/images/global/no-image.png';
    $lazyLoad = ($lazy_load) ? ' loading="lazy" ' : '';
    $decodingAsync = ($decoding_async) ? 'decoding="async"' : '';

    $thumbnail_id = get_post_thumbnail_id();
    $thumbnail_alt = get_post_meta($thumbnail_id, '_wp_attachment_image_alt', true);
    $thumbnail_alt = !empty($thumbnail_alt) ? $thumbnail_alt : get_the_title();
    $thumbnail_src = wp_get_attachment_image_src($thumbnail_id, $size_name);
    $thumbnail_srcset = wp_get_attachment_image_srcset($thumbnail_id, $size_name);
    $style = ($style) ? 'style="' . $style . ' "' : '';

    if (has_post_thumbnail() && $thumbnail_src) {
        return '<img width="' . $dimension["width"] . '" height="' . $dimension["height"] . '" class="' . $class . '" alt="' . esc_attr($thumbnail_alt) . '"  ' . $lazyLoad . ' ' . $decodingAsync . '  src="' . esc_url($thumbnail_src[0]) . '" ' . $style . '  />';
    } elseif ($default_img) {
        return '<img width="' . $dimension["width"] . '" height="' . $dimension["height"] . '" class="' . $class . '" alt="' . esc_attr(get_the_title()) . '" ' . $lazyLoad . ' ' . $decodingAsync . '  src="' . esc_url($default_thumbnail_url) . '" ' . $style . '  />';
    }
    return '';
}


/**
 * Make custom pagination 
 */
function i8_custom_pagination()
{
    global $wp_query;
    $total_posts = $wp_query->found_posts; // تعداد کل مطالب
    $big = 999999999; // عدد بزرگ برای جایگزینی در URL صفحه‌بندی

    $paginate_links = paginate_links(array(
        'base'    => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
        'format'  => '?paged=%#%', // فرمت URL صفحه‌های بندی
        'current' => max(1, get_query_var('paged')),
        'total'   => $wp_query->max_num_pages,
        'prev_next' => true,
        'prev_text' => '&lt; قبلی',
        'next_text' => 'بعدی &gt;',
    ));

    if ($paginate_links) {
?>
        <div class="row mt-3 py-2 mx-0 d-flex align-content-center justify-content-center">
            <div class="number-pagintion py-2 my-2">
                <div class="pagination pagination-archive">
                    <small>تعداد کل مطالب: <?php echo $total_posts; ?></small>
                    <?php echo $paginate_links; ?>
                </div>
            </div>
        </div>
    <?php
    }
}


/**
 * 
 * limit string-text by character-base system
 */
function i8_limit_text($text, $limit_count, $ending_text)
{
    // تنظیم محدودیت تعداد حروف  
    $limited_text = mb_substr($text, 0, $limit_count);

    // اگر عنوان اصلی بیشتر از محدودیت حرف بود، متن پایانی  را به عنوان نمایش ادامه اضافه کنید
    if (mb_strlen($text) > $limit_count) {
        $limited_text .= $ending_text;
    }

    // نمایش متن محدود شده
    echo $limited_text;
}

/**
 * 
 * 
 *  add Sub title to post edit page
 *
 * 
 */
function add_custom_subtitle_field()
{
    add_action('edit_form_after_title', 'custom_subtitle_field');
}

add_action('add_meta_boxes', 'add_custom_subtitle_field');

function custom_subtitle_field()
{
    $value = get_post_meta(get_the_ID(), '_post_subtitle', true);
    echo '<input type="text" class="widefat" id="post_subtitle" name="post_subtitle" value="' . esc_attr($value) . '" placeholder="روتیتر" size="25" />';
}

function save_post_subtitle($post_id)
{

    if (isset($_POST['post_subtitle'])) {
        update_post_meta($post_id, '_post_subtitle', sanitize_text_field($_POST['post_subtitle']));
    }
}

add_action('save_post', 'save_post_subtitle');




/**
 * 
 * Add Primary Category meta data Feature to post page 
 * با این قابلیت میتونیم یک دسته بندی اصلی از بین دسته های انتخاب شده در زمان انتشار مطلب انتخاب کنیم
 * 
 */

// اضافه کردن یک متا باکس جدید به صفحه ایجاد و ویرایش پست ها
add_action('add_meta_boxes', 'add_primary_category_meta_box');
function add_primary_category_meta_box()
{
    add_meta_box('primary_category_meta_box', 'دسته بندی اصلی', 'render_primary_category_meta_box', 'post', 'side', 'high');
}

// نمایش متا باکس دسته بندی اصلی
function render_primary_category_meta_box($post)
{
    // بررسی آیا دسته بندی اصلی قبلا انتخاب شده است
    $selected_category = get_post_meta($post->ID, 'hasht_primary_category', true);

    // دریافت لیست دسته بندی های پست ها
    $categories = get_categories(array('hide_empty' => false));

    // نمایش لیست کشویی با دسته بندی ها
    echo '<div class="misc-pub-section"><label for="hasht-primary-category">انتخاب دسته بندی اصلی:</label>';
    echo '<select name="hasht_primary_category" class="widefat" id="hasht-primary-category">';
    echo '<option value="">انتخاب کنید</option>';
    foreach ($categories as $category) {
        echo '<option value="' . esc_attr($category->cat_ID) . '" ' . selected($selected_category, $category->cat_ID, false) . '>' . esc_html($category->name) . '</option>';
    }
    echo '</select></div>';


    ?>
    <div class="misc-pub-section">
        <label for="hasht-reference-name">نام منبع:</label>
        <input type="text" name="hasht-reference-name" id="hasht-reference-name" class="widefat" value="<?php echo get_post_meta($post->ID, 'hasht-reference-name', true); ?>">
    </div>
    <div class="misc-pub-section">
        <label for="hasht-reference-link">لینک منبع:</label>
        <input type="text" name="hasht-reference-link" id="hasht-reference-link" class="widefat" value="<?php echo get_post_meta($post->ID, 'hasht-reference-link', true); ?>">
    </div>

<?php
    $i8_hide_date = (get_post_meta($post->ID, 'i8_hide_date', true) == 'on') ? ' checked' : '';
    // فیلد مخفی سازی تاریخ دلخواه
    echo '<div class="misc-pub-section"><label  for="i8_hide_date"> مخفی سازی تاریخ ';
    echo '<input type="checkbox" class="widefat" name="i8_hide_date" id="i8_hide_date" ' . $i8_hide_date . '>';
    echo '</label></div>';
}

// ذخیره مقدار دسته بندی اصلی
add_action('save_post', 'save_primary_category_meta_data');
function save_primary_category_meta_data($post_id)
{
    if (isset($_POST['hasht_primary_category'])) {
        update_post_meta($post_id, 'hasht_primary_category', sanitize_text_field($_POST['hasht_primary_category']));
    }

    if (isset($_POST['i8_hide_date'])) {
        update_post_meta($post_id, 'i8_hide_date', 'on');
    } else {
        update_post_meta($post_id, 'i8_hide_date', 'off');
    }

    if (isset($_POST['hasht-reference-name'])) {
        update_post_meta($post_id, 'hasht-reference-name', $_POST['hasht-reference-name']);
    }

    if (isset($_POST['hasht-reference-link'])) {
        update_post_meta($post_id, 'hasht-reference-link', $_POST['hasht-reference-link']);
    }
}

// retrive primary category name 
function i8_primary_category($post_id, $string_return = false)
{

    $primary_cat_id = (get_post_meta($post_id, 'hasht_primary_category') != '') ? get_post_meta($post_id, 'hasht_primary_category') : '';

    if (@$primary_cat_id[0] != '') :
        $primary_cat_name = get_the_category_by_ID(intval($primary_cat_id[0]));
        $primary_cat_url =  get_category_link(intval($primary_cat_id[0]));
        if (!$string_return) :
            return '<a class="post-category" href="' . $primary_cat_url . '" >' . $primary_cat_name . "</a>";
        else :
            return array('cat_id' => $primary_cat_id[0], 'cat_name' => $primary_cat_name, 'cat_url' => $primary_cat_url);
        endif;
    else :
        return false;
    endif;
}



/**
 * 
 * Create custom Menu Function - ساخت یک منوی سفارشی جدید 
 * 
 * 
 */

function build_custom_menu($items, $parent_id = 0)
{
    $menu = '';

    foreach ($items as $item) {
        if ($item->menu_item_parent == $parent_id) {
            // بررسی وجود زیرمنو
            $submenu = get_submenu_items($items, $item->ID);
            if (!empty($submenu)) {
                // اگر ساب منو داشت
                $menu .= '<li class="nav-item dropdown">';
                $menu .= '<a class="nav-link hasht-dropdown-toggle " id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" href="' . esc_url($item->url) . '">' . esc_html($item->title) . '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down mx-1" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"/>
              </svg>' .  '</a>';
                $menu .= '<ul class="dropdown-menu submenu box py-2" aria-labelledby="navbarDropdown">';
                $menu .= build_custom_menu($submenu, $item->ID); // فراخوانی بازگشایی
                $menu .= '</ul>';
            } else {
                //اگر ساب منو نداشت
                $menu .= '<li class="nav-item">';
                $menu .= '<a class="nav-link ';

                $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https://" : "http://";
                $url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
                if ($url == $item->url) {
                    $menu .= ' active fw-bold f15';
                }
                $menu .= '" href="' . esc_url($item->url) . '">' . esc_html($item->title) . '</a>';
            }
            $menu .= '</li>';
        }
    }

    return $menu;
}

// بررسی وجود ساب منو برای یک منو آیتم 
function get_submenu_items($items, $parent_id)
{
    $submenu = array();

    foreach ($items as $item) {
        if ($item->menu_item_parent == $parent_id) {
            $submenu[] = $item;
        }
    }
    // if($submenu) var_dump($submenu);
    return $submenu;
}

// بررسی اینکه صفحه فعلی و منوی آیتم برابر هستند یا نه
function is_current_page($url)
{
    global $wp;
    $current_url = home_url(add_query_arg(array(), $wp->request));
    return $current_url === $url;
}

// فراخوانی منو های که در یک لوکیشن ثبت شده اند و ساخت منو
function build_custom_menu_by_location($location, $style_type = 'row')
{
    $locations = get_nav_menu_locations();
    $menu_id = $locations[$location];

    $menu_items = wp_get_nav_menu_items($menu_id);

    if ($menu_items) {
        $type_class = ($style_type == 'column') ? 'flex-column' : 'flex-row';
        $gap = ($style_type == 'column') ? 'gap-0' : 'gap-3';
        echo '<ul class="navbar-nav mb-lg-0 menu-list d-flex ' . $type_class . ' g-2  px-0 ' . $gap . ' ">';
        echo build_custom_menu($menu_items);
        echo '</ul>';
    }
}
// فراخوانی منو های که در یک لوکیشن ثبت شده اند و ساخت منو
function build_custom_menu_by_id($menu_id, $style_type = 'row')
{
    $menu_items = wp_get_nav_menu_items($menu_id);

    if ($menu_items) {
        $type_class = ($style_type == 'column') ? 'flex-column menu-fix' : 'flex-row';
        $gap = ($style_type == 'column') ? 'column-gap-0' : 'column-gap-3';
        echo '<ul class="navbar-nav mb-lg-0 menu-list d-flex ' . $type_class . ' g-2  px-0 flex-wrap ' . $gap . ' ">';
        echo build_custom_menu($menu_items);
        echo '</ul>';
    }
}



/**
 * 
 * Bread Crumnb
 * 
 */
function i8_breadcrumb(
    $delimiter = ' &nbsp;/&nbsp; ', // جداکننده بین عناصر breadcrumb
    $home = 'صفحه اصلی', // متن لینک خانه
    $before = '<span class="current">', // قبل از عنوان صفحه فعلی
    $after = '</span>' // بعد از عنوان صفحه فعلی 
) {

    global $post;
    if (is_home() || is_front_page()) {
        echo '<a class="text-grey" href="' . home_url() . '">' . $home . '</a>';
    } else {
        echo '<a class="text-grey" href="' . home_url() . '">' . $home . '</a>' . $delimiter;
        if (is_single()) {
            if ($primary_cat = i8_primary_category(get_the_ID(), true)) :
                $cat_color   =   get_term_meta($primary_cat['cat_id'], 'i8_CustomTerm_color', true) ? get_term_meta($primary_cat['cat_id'], 'i8_CustomTerm_color', true) : 'var(--bs-secondary)';
                echo '<a class=""  href="' . $primary_cat['cat_url'] . '">' . $primary_cat['cat_name'] . '</a>';
            else :
            // the_category('/ ');
            // echo $delimiter;
            endif;
        } elseif (is_page()) {
            if ($post->post_parent) {
                $anc = get_post_ancestors($post->ID);
                $anc = array_reverse($anc);
                foreach ($anc as $ancestor) {
                    $output = '<a class="text-grey" href="' . get_permalink($ancestor) . '">' . get_the_title($ancestor) . '</a>' . $delimiter;
                }
                echo $output;
                echo $before . get_the_title() . $after;
            } else {
                echo $before . get_the_title() . $after;
            }
        } elseif (is_category()) {
            global $wp_query;
            $cat_obj = $wp_query->get_queried_object();
            $this_category = get_category($cat_obj->term_id);
            $parent_category = get_category($this_category->parent);
            if ($this_category->parent != 0)
                echo (get_category_parents($parent_category, TRUE, ' ' . $delimiter . ' '));
            echo $before . single_cat_title('', false) . $after;
        } elseif (is_tag()) {
            echo $before . single_tag_title('', false) . $after;
        } elseif (is_author()) {
            global $author;
            $userdata = get_userdata($author);
            echo $before . 'نویسنده: ' . $userdata->display_name . $after;
        } elseif (is_404()) {
            echo $before . 'خطای 404' . $after;
        } elseif (is_search()) {
            echo $before . 'نتایج جستجو برای: "' . get_search_query() . '"' . $after;
        } elseif (is_year()) {
            echo $before . get_the_time('Y') . $after;
        } elseif (is_month()) {
            echo $before . get_the_time('F Y') . $after;
        } elseif (is_day()) {
            echo $before . get_the_time('F j, Y') . $after;
        } elseif (is_post_type_archive()) {
            echo $before . post_type_archive_title('', false) . $after;
        } else {
            echo $before . get_the_title() . $after;
        }
    }
}


/**
 * hamberger mobile menu 
 */
function i8_mobile_menu($location)
{
    // آیتم های منوی یک لوکیشن را به صورت آرایه بازگردانی میکند
    $locations = get_nav_menu_locations();
    $menu_id = $locations[$location];

    $menu_name = wp_get_nav_menu_name($location);
    $menu_items = wp_get_nav_menu_items($menu_id);
    foreach ($menu_items as $menu_item) {
        if ($menu_item->menu_item_parent == 0) {
            $parent_menu[] = $menu_item;
        }
    }

    $menu = '';
    echo '<nav class="i8-h-menu">
            <input type="checkbox" id="menu" name="menu" class="m-menu__checkbox">
            <label class="m-menu__toggle" for="menu">
            <?xml version="1.0" encoding="UTF-8"?><svg width="32px" height="32px" stroke-width="1.5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" color="var(--i8-light-primary )"><path d="M8 6h12M4 6.01l.01-.011M4 12.01l.01-.011M4 18.01l.01-.011M8 12h12M8 18h12" stroke="var(--i8-light-primary )" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg>
            </label>
             <div class="m-menu">
                <div class="m-menu__header">
                    <span> ' . $menu_name . ' </span>

                    <label class="m-menu__toggle" for="menu">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="var(--i8-light-primary )" class="bi bi-x-lg" viewBox="0 0 16 16">
                          <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z"/>
                        </svg>
                    </label>
                </div>
                <ul class="p-0">
        ';
    $menu = print_mobile_menu($menu_items, $parent_menu);
    // print_r($menu);
    echo  '</ul></div></nav>';
}


function print_mobile_menu($all_items, $parent_items_level)
{
    //  var_dump($items);
    //  wp_die( 'end');

    foreach ($parent_items_level as $item) {
        // var_dump($items);
        // بررسی وجود زیرمنو
        $submenu = get_submenu_items($all_items, $item->ID);
        $menu = '';
        if (!empty($submenu)) {
            // اگر ساب منو داشت
            echo '<li>
                        <label class="a-label__chevron me-3" for="' . esc_html($item->title) . '">' . esc_html($item->title) . '</label>
                        <input type="checkbox" id="' . esc_html($item->title) . '" name="' . esc_html($item->title) . '" class="m-menu__checkbox">
                        <div class="m-menu">
                            <div class="m-menu__header">
                                <span>' . esc_html($item->title) . '</span>
                                <label class="m-menu__toggle" for="' . esc_html($item->title) . '">
                                    <svg width="35" height="35" viewBox="0 0 24 24" fill="none" stroke="var(--i8-light-primary )" stroke-width="1.5" stroke-linecap="butt" stroke-linejoin="arcs">
                                        <path d="M19 12H6M12 5l-7 7 7 7" />
                                    </svg>
                                </label>
                                
                            </div>
                            <ul class="p-0">';
            print_mobile_menu($all_items, $submenu);
            echo '</ul>
                        </div>
                    </li>';
        } else {
            //اگر ساب منو نداشت
            echo '<li><label><a href="' . esc_html($item->url) . '" >' . esc_html($item->title) . '</label></a></li>';
        }
    }

    // return $menu;
}

function customizeSVG($svg, $fill = '#000000', $stroke = '#000000', $width = 32, $height = 32, $class = "")
{
    // Check if the SVG is not empty
    if (!empty($svg)) {
        // Check if the SVG has fill="none"
        if (strpos($svg, 'fill="none"') !== false) {
            // Replace stroke attributes with the provided $stroke value
            $svg = preg_replace('/stroke="[^"]*"/', 'stroke="' . $stroke . '"', $svg);
        } else {
            // Replace fill attributes with the provided $fill value
            $svg = preg_replace('/fill="[^"]*"/', 'fill="' . $fill . '"', $svg);
        }
    }

    // Update width and height attributes
    $svg = preg_replace('/ width="[^"]*"/', ' width="' . $width . '"', $svg);
    $svg = preg_replace('/ height="[^"]*"/', ' height="' . $height . '" class="' . $class . '"', $svg);

    return $svg;
}

function i8_show_social_icons($width = 16, $height = 16)
{
    // echo get_option('i8_social_link_twitter');
    $twitter = sanitize_url(get_theme_mod('i8_social_link_twitter'));
    $instagram = sanitize_url(get_theme_mod('i8_social_link_instagram'));
    $telegram = sanitize_url(get_theme_mod('i8_social_link_telegram'));
    $youtube = sanitize_url(get_theme_mod('i8_social_link_youtube'));
    $aparat = sanitize_url(get_theme_mod('i8_social_link_aparat'));
    $whatsapp = sanitize_url(get_theme_mod('i8_social_link_whatsapp'));
    $facebook = sanitize_url(get_theme_mod('i8_social_link_facebook'));
?>
    <div class="d-flex">
        <div class="d-none d-xl-flex d-lg-flex d-md-flex justify-content-center gap-2 social-links">
            <?php if ($twitter) :  ?>
                <a class="p-0 p-lg-0 p-sm-1" target="_blank" href="<?php echo $twitter; ?>" alt="twitter share button" aria-label="twitter share button">
                    <svg xmlns="http://www.w3.org/2000/svg" width="<?php echo $width; ?>" height="<?php echo $height; ?>" fill="var(--i8-light-fg-color)" class="bi bi-twitter mx-1" viewBox="0 0 16 16">
                        <path d="M5.026 15c6.038 0 9.341-5.003 9.341-9.334 0-.14 0-.282-.006-.422A6.685 6.685 0 0 0 16 3.542a6.658 6.658 0 0 1-1.889.518 3.301 3.301 0 0 0 1.447-1.817 6.533 6.533 0 0 1-2.087.793A3.286 3.286 0 0 0 7.875 6.03a9.325 9.325 0 0 1-6.767-3.429 3.289 3.289 0 0 0 1.018 4.382A3.323 3.323 0 0 1 .64 6.575v.045a3.288 3.288 0 0 0 2.632 3.218 3.203 3.203 0 0 1-.865.115 3.23 3.23 0 0 1-.614-.057 3.283 3.283 0 0 0 3.067 2.277A6.588 6.588 0 0 1 .78 13.58a6.32 6.32 0 0 1-.78-.045A9.344 9.344 0 0 0 5.026 15z" />
                    </svg>
                </a>
            <?php endif; ?>
            <?php if ($facebook) :  ?>
                <a class="p-0 p-lg-0 p-sm-1" target="_blank" href="<?php echo $facebook; ?>" alt="facebook share button" aria-label="facebook share button">
                    <svg xmlns="http://www.w3.org/2000/svg" width="<?php echo $width; ?>" height="<?php echo $height; ?>" fill="var(--i8-light-fg-color)" class="bi bi-facebook mx-1" viewBox="0 0 16 16">
                        <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z" />
                    </svg>
                </a>
            <?php endif; ?>
            <?php if ($telegram) :  ?>
                <a class="p-0 p-lg-0 p-sm-1" href="<?php echo $telegram; ?>" alt="telegram share button" aria-label="telegram share button">
                    <svg xmlns="http://www.w3.org/2000/svg" width="<?php echo $width; ?>" height="<?php echo $height; ?>" fill="var(--i8-light-fg-color)" class="bi bi-telegram mx-1" viewBox="0 0 16 16">
                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.287 5.906c-.778.324-2.334.994-4.666 2.01-.378.15-.577.298-.595.442-.03.243.275.339.69.47l.175.055c.408.133.958.288 1.243.294.26.006.549-.1.868-.32 2.179-1.471 3.304-2.214 3.374-2.23.05-.012.12-.026.166.016.047.041.042.12.037.141-.03.129-1.227 1.241-1.846 1.817-.193.18-.33.307-.358.336a8.154 8.154 0 0 1-.188.186c-.38.366-.664.64.015 1.088.327.216.589.393.85.571.284.194.568.387.936.629.093.06.183.125.27.187.331.236.63.448.997.414.214-.02.435-.22.547-.82.265-1.417.786-4.486.906-5.751a1.426 1.426 0 0 0-.013-.315.337.337 0 0 0-.114-.217.526.526 0 0 0-.31-.093c-.3.005-.763.166-2.984 1.09z" />
                    </svg>
                </a>
            <?php endif; ?>
            <?php if ($whatsapp) :  ?>
                <a class="p-0 p-lg-0 p-sm-1" target="_blank" href="<?php echo $whatsapp; ?>" alt="whatsapp share button" aria-label="whatsapp share button">
                    <svg xmlns="http://www.w3.org/2000/svg" width="<?php echo $width; ?>" height="<?php echo $height; ?>" fill="var(--i8-light-fg-color)" class="bi bi-whatsapp mx-1" viewBox="0 0 16 16">
                        <path d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z" />
                    </svg>
                </a>
            <?php endif; ?>
            <?php if ($instagram) :  ?>
                <a class="p-0 p-lg-0 p-sm-1" target="_blank" href="<?php echo $instagram; ?>" alt="instagram share button" aria-label="instagram share button">
                    <svg xmlns="http://www.w3.org/2000/svg" width="<?php echo $width; ?>" height="<?php echo $height; ?>"  fill="var(--i8-light-fg-color)" class="bi bi-instagram mx-1" viewBox="0 0 16 16">
                        <path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.917 3.917 0 0 0-1.417.923A3.927 3.927 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.916 3.916 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.926 3.926 0 0 0-.923-1.417A3.911 3.911 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0h.003zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599.28.28.453.546.598.92.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.47 2.47 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.478 2.478 0 0 1-.92-.598 2.48 2.48 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233 0-2.136.008-2.388.046-3.231.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92.28-.28.546-.453.92-.598.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045v.002zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92zm-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217zm0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334z" />
                    </svg>
                </a>

            <?php endif; ?>
            <?php if ($youtube) :  ?>
                <a class="p-0 p-lg-0 p-sm-1" target="_blank" href="<?php echo $youtube; ?>" alt="youtube share button" aria-label="youtube share button">
                    <svg xmlns="http://www.w3.org/2000/svg" width="<?php echo $width; ?>" height="<?php echo $height; ?>" fill="var(--i8-light-fg-color)" class="bi bi-youtube mx-1" viewBox="0 0 16 16">
                        <path d="M8.051 1.999h.089c.822.003 4.987.033 6.11.335a2.01 2.01 0 0 1 1.415 1.42c.101.38.172.883.22 1.402l.01.104.022.26.008.104c.065.914.073 1.77.074 1.957v.075c-.001.194-.01 1.108-.082 2.06l-.008.105-.009.104c-.05.572-.124 1.14-.235 1.558a2.007 2.007 0 0 1-1.415 1.42c-1.16.312-5.569.334-6.18.335h-.142c-.309 0-1.587-.006-2.927-.052l-.17-.006-.087-.004-.171-.007-.171-.007c-1.11-.049-2.167-.128-2.654-.26a2.007 2.007 0 0 1-1.415-1.419c-.111-.417-.185-.986-.235-1.558L.09 9.82l-.008-.104A31.4 31.4 0 0 1 0 7.68v-.123c.002-.215.01-.958.064-1.778l.007-.103.003-.052.008-.104.022-.26.01-.104c.048-.519.119-1.023.22-1.402a2.007 2.007 0 0 1 1.415-1.42c.487-.13 1.544-.21 2.654-.26l.17-.007.172-.006.086-.003.171-.007A99.788 99.788 0 0 1 7.858 2h.193zM6.4 5.209v4.818l4.157-2.408L6.4 5.209z" />
                    </svg>
                </a>
            <?php endif; ?>
            <?php if ($aparat) :  ?>
                <a class="p-0 p-lg-0 p-sm-1" target="_blank" href="<?php echo $aparat; ?>" alt="aparat share button" aria-label="aparat share button">
                    <svg fill="var(--i8-light-fg-color)" width="<?php echo $width; ?>" height="<?php echo $height; ?>" class="bi bi-twitter mx-1" viewBox="0 0 24.00 24.00" role="img" xmlns="http://www.w3.org/2000/svg" transform="rotate(0)matrix(1, 0, 0, 1, 0, 0)" stroke="var(--i8-light-fg-color)" stroke-width="0.00024000000000000003">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" stroke="var(--i8-light-fg-color)" stroke-width="0.192"></g>
                        <g id="SVGRepo_iconCarrier">
                            <path d="M12.001 1.594c-9.27-.003-13.913 11.203-7.36 17.758a10.403 10.403 0 0 0 17.76-7.355c0-5.744-4.655-10.401-10.4-10.403zM6.11 6.783c.501-2.598 3.893-3.294 5.376-1.103 1.483 2.19-.422 5.082-3.02 4.582A2.97 2.97 0 0 1 6.11 6.783zm4.322 8.988c-.504 2.597-3.897 3.288-5.377 1.096-1.48-2.192.427-5.08 3.025-4.579a2.97 2.97 0 0 1 2.352 3.483zm1.26-2.405c-1.152-.223-1.462-1.727-.491-2.387.97-.66 2.256.18 2.04 1.334a1.32 1.32 0 0 1-1.548 1.053zm6.198 3.838c-.501 2.598-3.893 3.293-5.376 1.103-1.484-2.191.421-5.082 3.02-4.583a2.97 2.97 0 0 1 2.356 3.48zm-1.967-5.502c-2.598-.501-3.293-3.896-1.102-5.38 2.19-1.483 5.081.422 4.582 3.02a2.97 2.97 0 0 1-3.48 2.36zM13.59 23.264l2.264.61a3.715 3.715 0 0 0 4.543-2.636l.64-2.402a11.383 11.383 0 0 1-7.448 4.428zm7.643-19.665L18.87 2.97a11.376 11.376 0 0 1 4.354 7.62l.65-2.459A3.715 3.715 0 0 0 21.231 3.6zM.672 13.809l-.541 2.04a3.715 3.715 0 0 0 2.636 4.543l2.107.562a11.38 11.38 0 0 1-4.203-7.145zM10.357.702 8.15.126a3.715 3.715 0 0 0-4.547 2.637l-.551 2.082A11.376 11.376 0 0 1 10.358.702z"></path>
                        </g>
                    </svg>
                </a>

            <?php endif; ?>

        </div>
    </div>
<?php
}

// function add_html_to_paragraph($content)
// {
//     // بررسی آیا ما در صفحه نوشته هستیم و دارای پاراگراف‌ها هستیم
//     if (is_single()) {

//         // رشته کد HTML که می‌خواهیم اضافه کنیم
//         $html_code1 = '<div class="yn-bnr" id="ynpos-10546"></div>';
//         $html_code2 = '<div class="yn-bnr" id="ynpos-10767"></div>';
//         $html_code3 = '<div class="yn-bnr" id="ynpos-15072"></div>';

//         // تفکیک محتوا به پاراگراف‌ها
//         $paragraphs = explode('</p>', $content);
//         $paragraphs_count = count($paragraphs);
//         $ads1_pos =  ceil($paragraphs_count / 2);
//         // $ads2_pos =  floor($paragraphs_count / 4);
//         $paragraphs[3] .= $html_code1;
//         $paragraphs[12] .= $html_code2;
//         $paragraphs[($paragraphs_count - 1)] .= $html_code3;


//         // ایجاد محتوای جدید با پاراگراف‌های ویرایش شده
//         $content = implode('</p>', $paragraphs);
//     }
//     return $content;
// }
// add_filter('the_content', 'add_html_to_paragraph');
