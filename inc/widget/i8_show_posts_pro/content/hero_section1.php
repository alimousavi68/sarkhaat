<?php
echo $args['before_widget'];

if ($hide_title != 'on') {
  echo '<div class="text-title box-title  ' . $head_font_size . ' fw-7 m-0 me-2">';
  echo $args['before_title'] . $icon_print . $title  .  $args['after_title'];
  echo $sub_title_print . '</div>';
}

?>
<style>
  .multi-item {
    height: 276px;
  }

  .single-item-data {
    height: 100%;
  }
</style>

<?php
// <!-- mainslider-2 Single-Item -->

// نمایش محتویات ویجت- نمایش پست ها
$category_posts = new WP_Query(array(
  'posts_per_page' => 1,
  'cat'            => $cat,
  'order' => 'DESC',
  'orderby' => $orderby
));
if ($category_posts->have_posts()) : ?>
  <div class="col-24 col-xl-12  col-lg-12 col-md-12 col-sm-24 single-item d-flex flex-column gap-1 ps-2 border-start i8-border-md-none">
    <?php
    while ($category_posts->have_posts()) :
      $category_posts->the_post();
    ?>
      <a href="<?php the_permalink(); ?>">
        <?php echo i8_the_thumbnail('i8-lg-440-310', 'single-item-thumb w-100 i8-img-fit i8-img-fit', $dimenition = array('width' => 462, 'height' => 340), true, '', false, true); ?>
      </a>
      <div class="single-item-data d-flex flex-column gap-1">
        <span class="post-category f15"><?php echo i8_primary_category(get_the_ID()) ?></span>
        <h1 class="post-title <?php echo $title_font_size; ?> l1"><a href="<?php echo get_the_permalink(); ?>"><?php i8_limit_text(get_the_title(), 72, '...'); ?></a></h1>
        <?php if ($hide_excerpt != 'on') : ?>
          <p class="post-excerpt f15"><?php i8_limit_text(the_excerpt(), 120, '...'); ?></p>
        <?php endif; ?>
        <p class="post-publish-date f12 text-start text-subtitle"><?php the_date() ?></p>
      </div>
  <?php endwhile;
  endif; ?>
  </div>
  <!-- end single items -->

  <!-- multi items -->
  <div class="col-24 col-xl-12  col-lg-12 col-md-12 col-sm-24 multi-items d-flex gap-2">
    <?php
    $category_posts2 = new WP_Query(array(
      'posts_per_page' => 2,
      'cat'            => $cat,
      'order' => 'DESC',
      'offset' => '1',
      'orderby' => $orderby
    ));
    if ($category_posts2->have_posts()) : ?>
      <div class="col-12 d-flex flex-column gap-3 ps-2 border-start">
        <?php
        while ($category_posts2->have_posts()) :
          $category_posts2->the_post();
        ?>
          <div class="multi-item d-flex flex-column gap-2" style="border-bottom: 1px solid #ccc;">
            <a href="<?php the_permalink(); ?>">
              <?php echo i8_the_thumbnail('i8-lg-440-310', 'multi-item-thumb w-100 i8-img-fit', $dimenition = array('width' => 231, 'height' => 140), true, '', false, true); ?>
            </a>
            <div class="single-item-data d-flex flex-column gap-1 justify-content-between">
              <div class="title-box">
                <span class="post-category f15"><?php echo i8_primary_category(get_the_ID()) ?></span>
                <h1 class="post-title f15 <?php //echo $title_font_size; 
                                          ?> l1"><a href="<?php echo get_the_permalink(); ?>"><?php i8_limit_text(get_the_title(), 72, '...'); ?></a></h1>
              </div>
              <p class="post-publish-date f12 text-start text-subtitle my-0"><?php the_date() ?></p>
            </div>
          </div>

      <?php
        endwhile;
      endif;
      ?>
      </div>


    <?php
    $category_posts3 = new WP_Query(array(
      'posts_per_page' => 2,
      'cat'            => $cat,
      'order' => 'DESC',
      'offset' => '3',
      'orderby' => $orderby
    ));
    if ($category_posts3->have_posts()) : ?>
      <div class="col-12 d-flex flex-column gap-3 ps-2 i8-border-md-none" style="border-left: 1px solid #ccc;">
        <?php
        while ($category_posts3->have_posts()) :
          $category_posts3->the_post();
        ?>
          <div class="multi-item d-flex flex-column gap-2" style="border-bottom: 1px solid #ccc;">
            <a href="<?php the_permalink(); ?>">
              <?php echo i8_the_thumbnail('i8-lg-440-310', 'multi-item-thumb w-100 i8-img-fit', $dimenition = array('width' => 231, 'height' => 140), true, '', false, true); ?>
            </a>
            <div class="single-item-data d-flex flex-column gap-1 justify-content-between">
              <div class="title-box">
                <span class="post-category f15"><?php echo i8_primary_category(get_the_ID()) ?></span>
                <h1 class="post-title f15 <?php //echo $title_font_size; 
                                          ?> l1"><a href="<?php echo get_the_permalink(); ?>"><?php i8_limit_text(get_the_title(), 72, '...'); ?></a></h1>
              </div>
              <p class="post-publish-date f12 text-start text-subtitle my-0"><?php the_date() ?></p>
            </div>
          </div>

      <?php
        endwhile;
      endif;
      ?>
      </div>

    
      </div>

      <?php
      echo $args['after_widget'];
      ?>