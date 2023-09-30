<?php
class i8_show_post_numeric_list extends WP_Widget
{
    //داده های پیش فرض در صورت خالی رها شدن فیلدها
    private $default_field_data = array(
        'title' => '',
        'sub_title' => '',
        'cat'   => '-1',
        'num'   => '5',
        'icon'  => '',
        'icon_img'  => ''
    );
    //متد سازنده کلاس
    function __construct()
    {
        $opt_array = array(
            'class' => 'i8_category_posts_widget',
            'description' => 'نمایش پست های یک دسته بندی خاص با امکان تنظیم حالت های مختلف نمایش به صورت شماره ای'
        );
        parent::__construct('i8-category-posts', 'i8: نمایش پست های شماره ای', $opt_array);
    }
    //متد نمایش فرم در بخش تنظیمات 
    function form($instance)
    {
        $instance = wp_parse_args((array)$instance, $this->default_field_data);
        $title = esc_attr($instance['title']);
        $sub_title = esc_attr($instance['sub_title']);
        $num = esc_attr($instance['num']);
        $cat = esc_attr($instance['cat']);
        $icon = esc_attr($instance['icon']);
        $icon_img = esc_attr($instance['icon_img']);
?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>">عنوان</label>
            <input type="text" name="<?php echo $this->get_field_name('title'); ?>" id="<?php echo $this->get_field_id('title'); ?>" value="<?php echo $title; ?>" class="widefat">
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('sub_title'); ?>">زیر عنوان (متنی که در زیرعنوان قرار می گیرد)</label>
            <input type="text" name="<?php echo $this->get_field_name('sub_title'); ?>" id="<?php echo $this->get_field_id('sub_title'); ?>" value="<?php echo $sub_title; ?>" class="widefat">
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('icon'); ?>">آیکن ( کد آیکن بوت استرپ)</label>
            <input type="text" name="<?php echo $this->get_field_name('icon'); ?>" id="<?php echo $this->get_field_id('icon'); ?>" value="<?php echo $icon; ?>" class="widefat">
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('icon_img'); ?>">تصویر آیکن (آدرس تصویر)</label>
            <input type="text" name="<?php echo $this->get_field_name('icon_img'); ?>" id="<?php echo $this->get_field_id('icon_img'); ?>" value="<?php echo $icon_img; ?>" class="widefat">
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('num'); ?>">تعداد</label>
            <input type="number" name="<?php echo $this->get_field_name('num'); ?>" id="<?php echo $this->get_field_id('num'); ?>" value="<?php echo (!empty($num)) ? $num : 5; ?>" class="widefat">
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('cat'); ?>">دسته بندی</label>
            <select name="<?php echo $this->get_field_name('cat'); ?>" id="<?php echo $this->get_field_id('cat'); ?>" class="widefat">
                <option value="0">انتخاب کنید</option>
                <?php
                $categories = get_categories();
                foreach ($categories as $category) :
                    echo '<option value="' . $category->term_id . '" ' . selected($cat, $category->term_id, false) . '>' . $category->name . '</option>';
                endforeach;
                ?>
            </select>
        </p>
        <?php
    }
    //متد ذخیره تنظیمات ویجت 
    function update($new_instance, $old_instance)
    {
        // دیتای قبلی در متغییری که به خروجی فرستاده می شود ست می شود تا در صورت عدم تغییر از همین اطلاعات استفاده شود
        $instance = $old_instance;
        //در صورتی که کاربر فیلدی را خالی رها کرده بود و نیاز به دیتای پیش فرض داشت با این روش دیتای پیش فرض از قبل تعریف شده با دیتای جدید مرج می شود
        $new_instance = wp_parse_args((array)$new_instance, $this->default_field_data);
        //تغییر دیتای های قبلی با دیتای های جدید ثبت شده توسط کاربر
        $instance['title'] = sanitize_text_field($new_instance['title']);
        $instance['sub_title'] = sanitize_text_field($new_instance['sub_title']);
        $instance['num'] = sanitize_text_field($new_instance['num']);
        $instance['cat'] = sanitize_text_field($new_instance['cat']);
        $instance['icon'] = sanitize_text_field($new_instance['icon']);
        $instance['icon_img'] = sanitize_text_field($new_instance['icon_img']);

        return $instance;
    }
    // متد نمایش محتویات ویجت 
    function widget($args, $instance)
    {
        $title = apply_filters('wp_widget_title', $instance['title']);
        $sub_title = $instance['sub_title'];
        $sub_title_print = (!empty($sub_title)) ? '<p>' . $sub_title . '</p>' : '';
        $cat = $instance['cat'];
        $num = $instance['num'];
        $icon = $instance['icon'];
        $icon_print =  ($icon) ? '<i class="bi ' . $icon . '"></i>' : '';
        $icon_img = $instance['icon_img'];
        $icon_img_print =  (empty($icon) && !empty($icon_img)) ? '<img src="' . $icon_img . '"  />' : '';

        echo $args['before_widget'];
        if ($title) {
            echo '<div class="text-title box-title  ' . $head_font_size . ' fw-7 m-0 me-2">';
            echo $args['before_title'] . $icon_print . $icon_img_print . $title  .  $args['after_title'];
            echo $sub_title_print;
            echo '</div>';
        }

        echo '<ul class="numeric-list-content d-flex flex-wrap">';
        // نمایش محتویات ویجت- نمایش پست ها
        $category_posts = new WP_Query(array(
            'posts_per_page' => $num,
            'cat'            => $cat,
        ));

        if ($category_posts->have_posts()) {
            while ($category_posts->have_posts()) {
                $category_posts->the_post();
        ?>
                <li class="col-24 col-lg-24 col-md-12 col-sm-12">
                    <article class="numeric-list">
                        <div class="numeric-list-item d-flex justify-content-center align-items-center">
                            <div class="list-number">
                                <span><?php echo sprintf('%02d', $category_posts->current_post + 1); ?></span>
                            </div>
                            <div class="list-title">
                                <span class="post-category f15"><?php echo i8_primary_category(get_the_ID()) ?></span>
                                <a href="<?php the_permalink(); ?>"><?php i8_limit_text(get_the_title(), 55, '...'); ?></a>
                            </div>
                        </div>
                    </article>
                </li>
<?php
            }
            wp_reset_postdata();
        }
        echo '</ul>';
        echo $args['after_widget'];
    }
}


function i8_show_post_numeric_list()
{
    register_widget('i8_show_post_numeric_list');
}
add_action('widgets_init', 'i8_show_post_numeric_list');
