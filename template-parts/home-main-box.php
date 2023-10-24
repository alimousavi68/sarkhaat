<?php
?>
<div class="row mx-0 ">
  <div class="col-lg-18 col-md-24 col-sm-24 col-xl-18 d-flex flex-row flex-wrap ps-xl-3 px-0 px-lg-2 px-md-2 px-sm-0 px-xl-2">
    <div class="row d-flex flex-row flex-wrap">
      <div class="col-xl-16 col-lg-16 col-md-16 col-sm-24 d-flex flex-column flex-wrap ps-lg-2 ps-md-2 px-0 gap-1 i8-sticky">
        <?php dynamic_sidebar('hmr-sidebar'); ?>
      </div>
      <div class="col-xl-8 col-lg-8 col-md-8 col-sm-24 px-0 d-flex flex-column flex-wrap gap-1 i8-sticky">
        <?php dynamic_sidebar('hml-sidebar'); ?>
      </div>
    </div>
    <div class="col-xl-24 col-lg-24 col-md-24 col-sm-24 d-flex flex-row flex-wrap">
      <?php dynamic_sidebar('hms-sidebar'); ?>
    </div>
    <div class="row d-flex flex-row flex-wrap">
      <div class="col-xl-16 col-lg-16 col-md-16 col-sm-24 d-flex flex-column flex-wrap ps-2 gap-1 i8-sticky">
        <?php dynamic_sidebar('hmer-sidebar'); ?>
      </div>
      <div class="col-xl-8 col-lg-8 col-md-8 col-sm-24 px-0 d-flex flex-column flex-wrap gap-1 i8-sticky">
        <?php dynamic_sidebar('hmel-sidebar'); ?>
      </div>
    </div>
  </div>
  <!-- sidebar  -->
  <style>
    .market-btn:hover .btn-svg {
      fill: var(--i8-light-bg-color);
      /* stroke: var(--i8-light-bg-color); */
      transition-duration: 0.5s;
    }
  </style>
  <div class="border-end col-24 col-lg-6 col-md-24 col-sm-24 col-xl-6 d-flex flex-wrap gap-2 i8-border-md-none i8-sticky justify-content-center pe-0 pe-xl-3 ps-0 pt-4 pt-md-4 pt-xl-0">
    <?php
    dynamic_sidebar('hl-sidebar');
    ?>
  </div>
</div>