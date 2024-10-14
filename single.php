<?php
//header
get_header();
?>
<style>
    .releated-head {
        text-align: right;
        font-size: 16px !important;
        font-weight: 200;
        margin: 2px !important;
        padding: 0 !important;
        padding-right: 15px !important;
        border-right: 4px solid var(--i8-dark-complete-color);
    }

    .inline-related-box a {
        font-size: 15px;
    }
</style>

<div class="container px-0">
    <div class="row mx-0">

        <?php
        $post_structure = get_post_meta(get_the_ID(), 'i8_post_structure', true);

        $video_url = get_post_meta(get_the_ID(), 'hasht-video-link', true);
        $video_emebed = get_post_meta(get_the_ID(), 'hasht-video-embbed', true);

        // تشخیص نوع فایل ویدیو
        $file_extension = pathinfo($video_url, PATHINFO_EXTENSION);
        $is_video = in_array($file_extension, array('mp4', 'webm', 'ogg'));

        // اگر URL یک فایل ویدیویی است
        if ($post_structure == 'image'):
            get_template_part('template-parts/content/content-single-gallery');
        elseif ($post_structure == 'video' && ($is_video || $video_emebed)):
            get_template_part('template-parts/content/content-single-video');
        elseif ($post_structure == 'none-thumbnail'):
            get_template_part('template-parts/content/none-thumbnail');
        else:
            get_template_part('template-parts/content/content-single');
        endif;
        ?>

        <!-- sidebar  -->
        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-24 ps-0 pe-xl-2 pe-0 pe-sm-0 i8-sticky sl-sidebar">
            <?php dynamic_sidebar('sl-sidebar'); ?>
        </div>

    </div>
</div>



<?php
$num = 1;
$cat = 2464;
$args = array(
    'cat' => $cat, // استفاده از شناسه‌های دسته‌بندی
    'post__not_in' => array(get_the_ID()), // عدم دریافت خود پست فعلی
    'posts_per_page' => $num,
    'orderby' => 'rand', // ترتیب تصادفی
);

// اجرای پرس و جو برای بازیابی خبرهای مرتبط
$related_posts = new WP_Query($args);

// نمایش خبرهای مرتبط
if ($related_posts->have_posts()) {

    echo '<div class="suggestion-box" id="suggestionBox"><div class="row d-flex flex-wrap">';
    ?>
    <div class="d-flex flex-row justify-content-between align-items-start mx-0 px-0">
        <p class="f22 fw-7 mx-0 px-0 text-title"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30"
                class="icon_animate" viewBox="0 0 24 24">
                <path fill="#ff8080"
                    d="M12 6c-3.309 0-6 2.691-6 6s2.691 6 6 6s6-2.691 6-6s-2.691-6-6-6zm0 10c-2.206 0-4-1.794-4-4s1.794-4 4-4s4 1.794 4 4s-1.794 4-4 4z">
                </path>
                <path fill="#ff8080"
                    d="M12 2C6.579 2 2 6.579 2 12s4.579 10 10 10s10-4.579 10-10S17.421 2 12 2zm0 18c-4.337 0-8-3.663-8-8s3.663-8 8-8s8 3.663 8 8s-3.663 8-8 8z">
                </path>
                <path fill="#ff8080" d="M12 10c-1.081 0-2 .919-2 2s.919 2 2 2s2-.919 2-2s-.919-2-2-2z"></path>
            </svg>شما هم بخوانید</p>
        <button class="close-btn" id="closeBtn">&times;</button>

    </div>
    <?php
    while ($related_posts->have_posts()) {
        $related_posts->the_post();
        ?>

        <div class="mini-article d-flex px-0 ">
            <div width="<?php echo $thumb_width; ?>" height="<?php echo $thumb_height; ?>">

                <a href="<?php the_permalink(); ?>" class="image_frame">
                    <?php echo i8_the_thumbnail('i8-sm-100-75', 'hover', $dimenition = array('width' => 100, 'height' => 75), true, '', false, true); ?>
                </a>

            </div>
            <div class="d-flex flex-column ">
                <h4 class="me-2 l22-05 post-title">
                    <a class="i8-blink display-4 fw-4 l1" href="<?php echo get_the_permalink(); ?>">
                        <?php i8_limit_text(get_the_title(), 72, '...'); ?>
                    </a>
                </h4>
            </div>

        </div>

        <?php
    }
    echo '</div></div>';
}

// بازنشانی پست فعلی
wp_reset_postdata();
?>
</div>
<style>
    .suggestion-box {
        position: fixed;
        right: -350px;
        /* باکس در ابتدا مخفی است */
        bottom: 200px;
        width: 350px;
        background-color: white;
        border: 1px solid #ccc;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        padding: 15px;
        transition: right 0.3s ease;
        /* انیمیشن برای باز شدن باکس */
        z-index: 1000;
    }

    .suggestion-box.show {
        right: 20px;
        /* موقعیت نهایی باکس */
    }

    .close-btn {
        background: none;
        border: none;
        font-size: 20px;
        color: #aaa;
        cursor: pointer;
    }

    .close-btn:hover {
        color: #f00;
        /* رنگ دکمه در حالت hover */
    }
</style>
<script>
    window.addEventListener('scroll', function () {
        const suggestionBox = document.getElementById('suggestionBox');
        if (window.scrollY > 600) { // اگر کاربر بیش از 300 پیکسل اسکرول کرده باشد
            suggestionBox.classList.add('show'); // باکس را نمایش بده
        } else {
            suggestionBox.classList.remove('show'); // باکس را مخفی کن
        }
    });



    // اضافه کردن عملکرد بستن باکس
    const closeBtn = document.getElementById('closeBtn');
    closeBtn.addEventListener('click', function () {
        const suggestionBox = document.getElementById('suggestionBox');
        suggestionBox.classList.remove('show'); // باکس را مخفی کن
    });

</script>

<?php
//footer
get_footer();
?>