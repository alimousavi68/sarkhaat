<div class="related-post border-bottom mb-2">
    <div class="title-icon d-flex align-items-center mb-3 align-items-center">
        <p class="text-blue box-title f24 fw-7 m-0 me-2">مطالب مرتبط</p>
    </div>
<?php
// دریافت برچسب‌های مرتبط با پست فعلی
$post_tags = wp_get_post_tags(get_the_ID(), array('fields' => 'ids'));

// دریافت دسته‌بندی‌های مرتبط با پست فعلی
$post_categories = wp_get_post_categories(get_the_ID(), array('fields' => 'ids'));

// ساخت آرایه از آرگومان‌های برای بازیابی خبرهای مرتبط
$args = array(
    'post__not_in' => array(get_the_ID()), // عدم دریافت خود پست فعلی
    'posts_per_page' => 6,
    'orderby' => 'date',
    'order' => 'DESC',
    'tax_query' => array(
        'relation' => 'OR',
        array(
            'taxonomy' => 'post_tag',
            'field' => 'id',
            'terms' => $post_tags,
        ),
        array(
            'taxonomy' => 'category',
            'field' => 'id',
            'terms' => $post_categories,
        ),
    ),
);

// اجرای پرس و جو برای بازیابی خبرهای مرتبط
$related_posts = new WP_Query($args);

// نمایش خبرهای مرتبط
if ($related_posts->have_posts()) {
    echo '<div class="row d-flex flex-wrap">';
    while ($related_posts->have_posts()) {
        $related_posts->the_post();
?>
        <div class="mini-article d-flex col-md-12 col-sm-24 mb-3">
            <a href="<?php the_permalink(); ?>"><?php echo i8_the_thumbnail('hover i8-sm-85-67', 'ms-2'); ?></a>
            <a  class="f15 l2 me-2 l22-05 text-grey " href="<?php echo the_permalink(); ?>"><?php echo get_the_title(); ?></a>
        </div>
<?php
    }
    echo '</div>';
}

// بازنشانی پست فعلی
wp_reset_postdata();
?>


   
</div>