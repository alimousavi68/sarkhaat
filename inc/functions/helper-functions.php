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
        echo '<ul class="navbar-nav mb-lg-0 menu-list d-flex ' . $type_class . ' g-2  px-0 '. $gap .' ">';
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
        echo '<ul class="navbar-nav mb-lg-0 menu-list d-flex ' . $type_class . ' g-2  px-0 flex-wrap '. $gap .' ">';
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
