<!DOCTYPE html>
<html lang="fa">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="<?php echo (get_theme_mod('i8_light_primary_color')) ? get_theme_mod('i8_light_primary_color') : '#0A93CD'; ?>" />
    <title><?php bloginfo('title'); ?></title>
    <?php wp_head(); ?>
    <?php if (is_singular()) : ?>
        <style media="print">
            .sl-sidebar,
            .sub-header,
            .breadcrumb,
            .bottom-content-bar,
            .related-post,
            #footer,
            .top-menu,#comments {
                display: none !important;
            }
        </style>

    <?php endif; ?>
    <style>
        .top-menu {
            display: flex;
            padding: 1px;
            justify-content: space-between;
            align-items: center;
            align-self: stretch;
            background: #1171B7;
            height: 29px;
            color: white;
        }

        .bottom-menu {
            /* display: flex;
            padding: 1px;
            justify-content: space-between;
            align-items: center;
            align-self: stretch; */
            background: #1171B7;
            color: white;
        }

        .row {
            margin: 0px !important;
            padding: 0px !important;
        }

        .round-icon {
            background-color: #1e6fb7;
            border-radius: 50%;
            width: 32px;
            height: 32px;
            color: white;
        }
    </style>
</head>

<body dir="rtl" class="bg-main">
    <!-- header -->
    <header id="header">
        <!-- top menu -->
        <div class="row">
            <div class="col-24 top-menu ">
                <div class="container d-flex justify-content-center justify-content-between p-1 align-items-center">
                    <span class="d-flex f13"><?php echo date('l j F - H:i:s'); ?></span>
                    <div class="d-flex">
                        <div class="d-none d-xl-flex d-lg-flex d-md-flex justify-content-center gap-2 social-links">
                            <a class="p-0 p-lg-0 p-sm-1" href="https://twitter.com/intent/tweet?url=<?php the_permalink(); ?>" alt="twitter share button" aria-label="twitter share button">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="var(--i8-light-fg-color)" class="bi bi-twitter mx-1" viewBox="0 0 16 16">
                                    <path d="M5.026 15c6.038 0 9.341-5.003 9.341-9.334 0-.14 0-.282-.006-.422A6.685 6.685 0 0 0 16 3.542a6.658 6.658 0 0 1-1.889.518 3.301 3.301 0 0 0 1.447-1.817 6.533 6.533 0 0 1-2.087.793A3.286 3.286 0 0 0 7.875 6.03a9.325 9.325 0 0 1-6.767-3.429 3.289 3.289 0 0 0 1.018 4.382A3.323 3.323 0 0 1 .64 6.575v.045a3.288 3.288 0 0 0 2.632 3.218 3.203 3.203 0 0 1-.865.115 3.23 3.23 0 0 1-.614-.057 3.283 3.283 0 0 0 3.067 2.277A6.588 6.588 0 0 1 .78 13.58a6.32 6.32 0 0 1-.78-.045A9.344 9.344 0 0 0 5.026 15z" />
                                </svg>
                            </a>
                            <a class="p-0 p-lg-0 p-sm-1" href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>" alt="facebook share button" aria-label="facebook share button">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="var(--i8-light-fg-color)" class="bi bi-facebook mx-1" viewBox="0 0 16 16">
                                    <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z" />
                                </svg>
                            </a>
                            <a class="p-0 p-lg-0 p-sm-1" href="https://t.me/share/url?url=<?php the_permalink(); ?>" alt="telegram share button" aria-label="telegram share button">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="var(--i8-light-fg-color)" class="bi bi-telegram mx-1" viewBox="0 0 16 16">
                                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.287 5.906c-.778.324-2.334.994-4.666 2.01-.378.15-.577.298-.595.442-.03.243.275.339.69.47l.175.055c.408.133.958.288 1.243.294.26.006.549-.1.868-.32 2.179-1.471 3.304-2.214 3.374-2.23.05-.012.12-.026.166.016.047.041.042.12.037.141-.03.129-1.227 1.241-1.846 1.817-.193.18-.33.307-.358.336a8.154 8.154 0 0 1-.188.186c-.38.366-.664.64.015 1.088.327.216.589.393.85.571.284.194.568.387.936.629.093.06.183.125.27.187.331.236.63.448.997.414.214-.02.435-.22.547-.82.265-1.417.786-4.486.906-5.751a1.426 1.426 0 0 0-.013-.315.337.337 0 0 0-.114-.217.526.526 0 0 0-.31-.093c-.3.005-.763.166-2.984 1.09z" />
                                </svg>
                            </a>
                            <a class="p-0 p-lg-0 p-sm-1" href="https://wa.me/?text=<?php the_permalink(); ?>" alt="whatsapp share button" aria-label="whatsapp share button">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="var(--i8-light-fg-color)" class="bi bi-whatsapp mx-1" viewBox="0 0 16 16">
                                    <path d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z" />
                                </svg>
                            </a>

                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- End - top menu -->
        <!-- Main header -->
        <div class="row ">
            <div class="col-24 d-flex justify-content-center justify-content-lg-between white-shadow py-3 px-0 d-flex align-items-center border-bottom">
                <div class="container d-flex justify-content-center justify-content-between align-items-center px-lg-0">
                    <div class="col-18 col-md-2 d-flex w-auto gap-4">
                        <a href="<?php echo bloginfo('url') ?>" title="<?php bloginfo('title'); ?> " class="logo">
                            <img width="177" height="70" class="header-logo" src="<?php echo get_stylesheet_directory_uri(); ?>/images/global/rasaderooz.ir-logo.webp" alt="logo" />
                        </a>
                        <div class="d-none d-lg-flex align-items-center">
                            <?php build_custom_menu_by_location('primary'); ?>
                        </div>
                    </div>
                    <div class="col-auto py-2 d-flex align-items-center justify-content-between gap-2 gap-lg-2 gap-sm-2">

                        <div class="d-flex d-lg-none">
                            <?php i8_mobile_menu('primary'); ?>
                        </div>
                        <div class="d-flex justify-content-end align-items-center gap-2 gap-lg-2 gap-sm-2">
                            <a href="#" class="dark-mode-switch  px-1 px-lg-0 px-sm-1 round-icon d-flex justify-content-center align-items-center" alt="dark mode button" aria-label="dark mode button">
                                <svg class="" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="var(--i8-light-fg-color)" class="bi bi-brightness-high" viewBox="0 0 16 16">
                                    <path d="M8 11a3 3 0 1 1 0-6 3 3 0 0 1 0 6zm0 1a4 4 0 1 0 0-8 4 4 0 0 0 0 8zM8 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 0zm0 13a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 13zm8-5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .5.5zM3 8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2A.5.5 0 0 1 3 8zm10.657-5.657a.5.5 0 0 1 0 .707l-1.414 1.415a.5.5 0 1 1-.707-.708l1.414-1.414a.5.5 0 0 1 .707 0zm-9.193 9.193a.5.5 0 0 1 0 .707L3.05 13.657a.5.5 0 0 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0zm9.193 2.121a.5.5 0 0 1-.707 0l-1.414-1.414a.5.5 0 0 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .707zM4.464 4.465a.5.5 0 0 1-.707 0L2.343 3.05a.5.5 0 1 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .708z" />
                                </svg>
                            </a>
                            <a href="<?php echo home_url('/?s'); ?>" class=" px-1 px-lg-0 px-sm-1 round-icon d-flex justify-content-center align-items-center" alt="search button" aria-label="search button">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="var(--i8-light-fg-color)" class="bi bi-search" viewBox="0 0 16 16">
                                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>


            <?php
            if(function_exists('show_market_bar'))
            {
                show_market_bar();
            }
            ?>
        </div>
    </header>
    <!-- header  -->