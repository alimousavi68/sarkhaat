<?php
echo $args['before_widget'];
if ($hide_title != 'on') { ?>
    <div class="col-4 d-flex flex-column px-0 gap-0 align-items-start">
        <p class="box-title <?php echo $head_font_size; ?> fw-7 mb-1">
            <?php echo $args['before_title'] . $icon_print . $title . $args['after_title']; ?>
        </p>
        <p class=" f14 fw-4 text-grey mb-3">
            <?php echo $sub_title_print; ?>
        </p>
        <p class="display-5 fw-4 mb-2">
            <a class="cat_btn_link" href="<?php echo '/category' . '/' . $cat ?>">دیدن همه</a>
        </p>
    </div>
<?php } ?>

<?php
// نمایش محتویات ویجت- نمایش پست ها
$category_posts = new WP_Query(
    array(
        'posts_per_page' => $num,
        'cat' => $cat,
        'order' => 'DESC',
        'orderby' => $orderby
    )
);

echo '<div class="col-20 d-flex flex-row flex-wrap px-0">';
echo '<div class="row">';
if ($category_posts->have_posts()) {
    while ($category_posts->have_posts()) {
        $category_posts->the_post();
        ?>
        <div class="<?php echo $col; ?> d-flex flex-column multi-item px-2 gap-2">
            <a href="<?php the_permalink(); ?>" class="image_frame">
                <?php echo i8_the_thumbnail('i8-md-219-140', 'multi-item-thumb hover w-100 i8-img-fit', $dimenition = array('width' => 220, 'height' => 160), true, '', false, true); ?>
            </a>
            <div class="single-item-data d-flex flex-column gap-1">
                <div class="title-box">
                    <h1 class="post-title <?php echo $title_font_size; ?> <?php echo $title_font_weight; ?>  l1"><a href="<?php echo get_the_permalink(); ?>">
                            <?php i8_limit_text(get_the_title(), 82, '...'); ?>
                        </a></h1>
                </div>
                <p class="post-publish-date f12 text-end text-subtitle my-0">
                    <?php the_date() ?>
                </p>
            </div>
        </div>
        <?php
    }
    wp_reset_postdata();
}
echo '</div>';
echo '</div>';

echo $args['after_widget'];

?>