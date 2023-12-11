<div class="archive-card d-flex flex-column-reverse flex-xl-row flex-lg-row flex-md-row row-gap-3 border-bottom py-3">
    <div class="archive-thumb col-lg-6 col-md-6 col-sm-24  px-0 px-xl-2 px-lg-2">
        <a href="<?php the_permalink(); ?>" class="image_frame">
            <?php echo i8_the_thumbnail('i8-md-228-231', 'hover w-100 object-fit-cover i8-h-md-100', $size = array('width' => 'auto', 'height' => 139), true, '', false, true) ?>
        </a>
    </div>
    <div class="d-flex flex-column col-lg-18 col-md-18 col-sm-24  gap-1">
        <h4
            class="post-title text-center text-xl-end text-lg-end text-md-center text-sm-center  justify-content-between flex-column">
            <a href="<?php the_permalink(); ?>" class="display-3 i8-blink d-inline">
                <?php i8_limit_text(get_the_title(), 250, '...'); ?>
            </a>
        </h4>
        <p class="text-justify f15">
            <?php i8_limit_text(get_the_excerpt(), 240, '...'); ?>
        </p>
    </div>

</div>