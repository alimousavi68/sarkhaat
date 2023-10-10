<?php 
echo $args['before_widget'];

echo '<div class="text-title box-title  ' . $head_font_size . ' fw-7 m-0 me-lg-2 me-md-2">';
if ($hide_title != 'on') {
    echo $args['before_title'] . $icon_print . $title  .  $args['after_title'];
}
echo $sub_title_print . '</div>';

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
                         <span class="post-category f14"><?php echo i8_primary_category(get_the_ID()) ?></span> 
                        <a href="<?php the_permalink(); ?>" class="f18"><?php i8_limit_text(get_the_title(), 55, '...'); ?></a>
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