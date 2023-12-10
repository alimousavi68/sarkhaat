<?php
?>
<div class="row mx-0 ">
  <div class="col-lg-18 col-md-24 col-sm-24 col-xl-18 d-flex flex-row flex-wrap px-0 gap-2">
    <div class="row d-flex flex-row flex-wrap">
      <div class="col-xl-7 col-lg-7 col-md-7 col-sm-24  d-flex flex-column flex-wrap pe-0 gap-1 i8-sticky">
        <?php dynamic_sidebar('hml-sidebar'); ?>
      </div>
      <div class="col-xl-17 col-lg-17 col-md-17 col-sm-24 d-flex flex-column flex-wrap gap-1 i8-sticky">
        <?php dynamic_sidebar('hmr-sidebar'); ?>
      </div>

    </div>
    <div class="row">
      <div class="col-xl-24 col-lg-24 col-md-24 col-sm-24 d-flex flex-row flex-wrap pe-0">
        <?php dynamic_sidebar('hms-sidebar'); ?>
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
  <div
    class="col-24 col-lg-6 col-md-24 col-sm-24 col-xl-6 d-flex flex-wrap gap-2 i8-sticky justify-content-center ps-0">
    <?php
    dynamic_sidebar('hl-sidebar');
    ?>
  </div>

</div>

<div class="row d-flex flex-row flex-wrap">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-24 pe-0 d-flex flex-column flex-wrap gap-4">
      <?php dynamic_sidebar('hmer-sidebar'); ?>
    </div>
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-24 ps-0 d-flex flex-column flex-wrap gap-4">
      <?php dynamic_sidebar('hmel-sidebar'); ?>
    </div>
  </div>