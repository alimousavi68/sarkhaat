<?php
echo $args['before_widget'];

echo '<div class="text-title box-title  ' . $head_font_size . ' fw-7 m-0 me-2">';
if ($hide_title != 'on') {
  echo $args['before_title'] . $icon_print . $title . $args['after_title'];
}
echo $sub_title_print . '</div>';

?>
<style>
  .multi-items {
    border-bottom: 1px solid #ccc;
  }

  .multi-items:last-child {
    border-bottom: 0px;
  }
</style>


<div class="col-24 col-xl-24  col-lg-24 col-md-24 col-sm-24 multi-items d-flex gap-2">
  <div class="row row-gap-3">
    <?php

    $category_posts2 = new WP_Query(
      array(
        'posts_per_page' => 1,
        'cat' => $cat,
        'order' => 'DESC',
        'orderby' => $orderby
      )
    );

    // left
    if ($category_posts2->have_posts()) { ?>
      <?php
      while ($category_posts2->have_posts()) {
        $category_posts2->the_post();
        ?>
        <div class="multi-item d-flex flex-column gap-2 border-bottom">
          <a href="<?php the_permalink(); ?>">
            <?php echo i8_the_thumbnail('i8-md-219-140', 'multi-item-thumb w-100 i8-img-fit', $dimenition = array('width' => 231, 'height' => 140), true, '', false, true); ?>
          </a>
          <div class="single-item-data d-flex flex-column gap-1 justify-content-between">
            <div class="title-box">
              <span class="post-category f15">
                <?php echo i8_primary_category(get_the_ID()) ?>
              </span>

              <h1 class="post-title <?php echo $title_font_size; ?> <?php echo $title_font_weight; ?> l1">
                <a href="<?php echo get_the_permalink(); ?>">
                  <?php i8_limit_text(get_the_title(), 200, '...'); ?>
                </a>
              </h1>
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

    // نمایش محتویات ویجت- نمایش پست ها
    $category_posts = new WP_Query(
      array(
        'posts_per_page' => $num - 1,
        'cat' => $cat,
        'order' => 'DESC',
        'offset' => 1,
        'orderby' => $orderby
      )
    );
    ?>

    <?php
    if ($category_posts->have_posts()) { ?>
      <?php
      while ($category_posts->have_posts()) {
        $category_posts->the_post();
        ?>

        <div class="multi-items d-flex flex-column gap-2 border-bottom">
          <div class="single-item-data d-flex flex-column gap-1 justify-content-between">
            <div class="title-box">
              <span class="post-category f15">
                <?php echo i8_primary_category(get_the_ID()) ?>
              </span>

              <h1 class="post-title <?php echo $title_font_size; ?> <?php echo $title_font_weight; ?> l1"><a
                  href="<?php echo get_the_permalink(); ?>">
                  <?php i8_limit_text(get_the_title(), 200, '...'); ?>
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
    ?>




  </div>
</div>

<?php
echo $args['after_widget'];
?>