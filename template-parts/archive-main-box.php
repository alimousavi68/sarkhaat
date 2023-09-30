<?php ?>
<div class="row mx-0">
  <div class="col-xl-17 col-md-24 col-sm-24 pe-0 ps-2 ps-lg-2 ps-sm-0 d-flex flex-column gap-1 ">

    <div class="box row d-flex py-3 mx-0 align-content-center row-gap-3">
      <div class="col-md-12 col-sm-24 text-center text-md-end ">
        <?php

        $cat = get_queried_object();
        $cat_color   =   get_term_meta($cat->term_id, 'i8_CustomTerm_color', true) ? get_term_meta($cat->term_id, 'i8_CustomTerm_color', true) : '#000';
        $cat_icon   =   get_term_meta($cat->term_id, 'i8_CustomTerm_icon', true) ? get_term_meta($cat->term_id, 'i8_CustomTerm_icon', true) : '';
        $icon_print =  ($cat_icon) ? customizeSVG($cat_icon, $cat_color, $cat_color, 30, 30) : '';

        echo '<span class="title f24 ms-2"> ' . $icon_print . '</span>' . '<span >' . $cat->name . '</span>';
        the_archive_description('<p>', '</p>');
        ?>
      </div>
      <div class="col-md-12 col-sm-24 mb-0 d-flex flex-row  justify-content-center justify-content-md-end text-gray f14 " aria-label="breadcrumb">
        <?php i8_breadcrumb(); ?>
      </div>
    </div>
    <?php
    if (have_posts()) :
      while (have_posts()) :
        the_post();
        get_template_part('template-parts/content/content-archive');
      endwhile;
      // Pagination
      i8_custom_pagination();
    else :
      //to do 
      echo '<p>پستی وجو ندارد!</p>';
    endif;
    ?>
  </div>


  <!-- sidebar  -->
  <div class="col-xl-7 col-md-24 col-sm-24 ps-0 pt-4 pt-xl-0 pt-md-4 pt-sm-4  pe-xl-3 pe-0 pe-sm-0 i8-sticky">
    <div class="box">
      <?php
      dynamic_sidebar('al-sidebar');
      ?>
    </div>
  </div>
</div>