<?php
?>
<div class="row mx-0 ">
  <div class="col-xl-18 col-lg-18 col-md-24 col-sm-24 ps-xl-3 d-flex flex-row flex-wrap">
    <div class="row d-flex flex-row flex-wrap">
      <div class="col-xl-16 col-lg-16 col-md-16 col-sm-24 d-flex flex-column flex-wrap ps-2 gap-4 i8-sticky">
        <?php dynamic_sidebar('hmr-sidebar'); ?>
      </div>
      <div class="col-xl-8 col-lg-8 col-md-8 col-sm-24 px-0 d-flex flex-column flex-wrap gap-4 i8-sticky">
        <?php dynamic_sidebar('hml-sidebar'); ?>
      </div>
    </div>
    <div class="col-xl-24 col-lg-24 col-md-24 col-sm-24 d-flex flex-row flex-wrap">
      <?php dynamic_sidebar('hms-sidebar'); ?>
    </div>
    <div class="row d-flex flex-row flex-wrap">
      <div class="col-xl-16 col-lg-16 col-md-16 col-sm-24 d-flex flex-column flex-wrap ps-2 gap-4 i8-sticky">
        <?php dynamic_sidebar('hmer-sidebar'); ?>
      </div>
      <div class="col-xl-8 col-lg-8 col-md-8 col-sm-24 px-0 d-flex flex-column flex-wrap gap-4 i8-sticky">
        <?php dynamic_sidebar('hmel-sidebar'); ?>
      </div>
    </div>
  </div>
  <!-- sidebar  -->
  <div class="col-24 col-xl-6 col-lg-6 col-md-24 col-sm-24 ps-0 pt-xl-0 pt-md-4 pt-4 pe-xl-3 pe-0 i8-sticky border-end i8-border-md-none">
    <?php
    dynamic_sidebar('hl-sidebar');
    ?>
  </div>
</div>