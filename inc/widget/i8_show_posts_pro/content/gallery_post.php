<?php
echo $args['before_widget'];
echo '<div class="title-icon d-flex align-items-center mb-3">';
echo '<div class="text-title box-title  ' . $head_font_size . ' fw-7 m-0 me-2">';
if ($hide_title != 'on') {
    echo $args['before_title'] . $icon_print . $title  .  $args['after_title'];
}
echo $sub_title_print . '</div></div>';

// نمایش محتویات ویجت - نمایش پست ها
$category_posts = new WP_Query(array(
    'posts_per_page' => $num,
    'cat'            => $cat,
    'order' => 'DESC',
    'orderby' => $orderby
));

if ($category_posts->have_posts()) {
    while ($category_posts->have_posts()) {
        $category_posts->the_post();

        $primary_cat = get_post_meta(get_the_ID(), 'hasht_primary_category');
        $primary_cat_color = get_term_meta($primary_cat[0], 'i8_CustomTerm_color', true) ? get_term_meta($primary_cat[0], 'i8_CustomTerm_color', true) : '#000000';
        $primary_cat_color_transparent = $primary_cat_color . 'c4';
?>
        <div class="<?php echo $col; ?> px-1">
            <div class="post-flip-box-container">
                <?php echo i8_the_thumbnail('i8-xl-625-486', 'post-flip-box-image object-fit-cover' . $thumb_radius, array("width" => $thumb_width, "height" => $thumb_height)); ?>

                <div class="post-flip-box-link-wrapper">
                    <a href="post1.html" class="post-flip-box-link"></a>
                </div>
                <div class="post-flip-box-overlay d-flex align-items-center">
                    <h2 class="post-flip-box-title">
                        <a class="<?php echo $title_font_size; ?> post-flip-box-link l1 text-white" href="<?php echo get_the_permalink(); ?>"><?php i8_limit_text(get_the_title(), 72, '...'); ?></a>
                    </h2>
                </div>
            </div>
        </div>
<?php
    }
    wp_reset_postdata();
}

if ($hide_thumb != 'on') :
    echo '</div>';
else :
    echo '</ul>';
endif;

echo $args['after_widget'];


?>



