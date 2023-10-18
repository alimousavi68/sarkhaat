<?php
echo $args['before_widget'];
echo '<div class="box"><div class="title-icon d-flex align-items-center align-items-center mb-3">';

echo '<p class="text-title f24 fw-7 me-2 mb-0" >';
if ($hide_title != 'on') {
  echo $args['before_title'] . $icon_print . $title  .  $args['after_title'];
}
echo $sub_title_print . '</p></div>';

echo '<div class="row row-gap-3">';
// نمایش محتویات ویجت- نمایش پست ها
$category_posts = new WP_Query(array(
  'posts_per_page' => $num,
  'cat'            => $cat,
  'order' => 'DESC',
  'orderby'=> $orderby
));

if ($category_posts->have_posts()) {
  while ($category_posts->have_posts()) {
    $category_posts->the_post();
    if (($category_posts->current_post + 1) === 1) :
?>
      <div class="news-card col-xl-13 col-md-13 col-sm-24 text-center text-xl-end text-lg-end text-md-end text-sm-center d-flex flex-column row-gap-2">
        <a href="<?php the_permalink(); ?>" ><?php echo i8_the_thumbnail('i8-lg-446-340', 'hover w-100 object-fit-cover rounded-15', 310); ?></a>
        <a class="text-grey h-fs-7" href="<?php echo get_the_permalink(); ?>"><?php i8_limit_text(get_the_title(), 72, '...'); ?></a>
      </div>
      <div class="col-xl-11 col-md-11 col-sm-24 row">
      <?php endif;
    if (($category_posts->current_post + 1) > 1) :
      ?>
        <div class="<?php echo $col; ?>  mini-article d-flex align-items-center mb-3">
          <a href="<?php the_permalink(); ?>"><?php echo i8_the_thumbnail('i8-sm-130-88', 'hover'); ?></a>
          <a class="f15 me-2 l22-05 text-grey" href="<?php echo get_the_permalink(); ?>"><?php i8_limit_text(get_the_title(), 72, '...'); ?></a>
        </div>
  <?php
    endif;
    wp_reset_postdata();
  }
}
echo '</div>';
echo '</div>';
echo '</div>';
echo $args['after_widget'];

  ?>