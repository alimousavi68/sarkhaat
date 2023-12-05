<?php
echo $args['before_widget'];
if ($hide_title != 'on') { ?>
    <div class="col-3 d-flex flex-column px-0">
        <p class="box-title <?php echo $head_font_size; ?> fw-7">
            <?php echo $args['before_title'] . $icon_print . $title . $args['after_title']; ?>
        </p>
        <p class=" f10 fw-1">
            <?php echo $sub_title_print; ?>
        </p>
        <p class="display-6 fw-1 ">
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

echo '<div class="col-21 d-flex flex-row flex-wrap px-0">';
echo '<div class="row">';
if ($category_posts->have_posts()) {
    while ($category_posts->have_posts()) {
        $category_posts->the_post();
        ?>
        <div class="col-24 col-lg-8 col-md-8 col-sm-24 d-flex flex-column multi-item px-2 gap-2">
            <a href="<?php the_permalink(); ?>">
                <?php echo i8_the_thumbnail('i8-md-219-140', 'multi-item-thumb hover w-100 i8-img-fit', $dimenition = array('width' => 164, 'height' => 96), true, '', false, true); ?>
            </a>
            <div class="single-item-data d-flex flex-column gap-1">
                <div class="title-box">
                    <h1 class="post-title f14 fw-4 l1"><a href="<?php echo get_the_permalink(); ?>">
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