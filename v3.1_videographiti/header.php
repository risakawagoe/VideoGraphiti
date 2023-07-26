<!DOCTYPE html>
<html lang="ja">
<head>
    <!-- meta tag -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="format-detection" content="email=no, telephone=no, address=no">



    <!-- page info -->
    <meta name="title" content="<?php echo get_bloginfo('name') ?>">
    <meta name="description" content="<?php echo get_bloginfo('name') ?> - <?php echo get_bloginfo('description') ?>">
    <title><?php echo get_bloginfo('name') ?></title>

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo home_url(); ?>">
    <meta property="og:title" content="<?php echo get_bloginfo('name') ?>">
    <meta property="og:description" content="<?php echo get_bloginfo('name') ?> - <?php echo get_bloginfo('description') ?>">
    <meta property="og:image" content="">
    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="<?php echo home_url(); ?>">
    <meta property="twitter:title" content="<?php echo get_bloginfo('name') ?>">
    <meta property="twitter:description" content="<?php echo get_bloginfo('name') ?> - <?php echo get_bloginfo('description') ?>">
    <meta property="twitter:image" content="">




    <!-- favicon -->
    <link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/images/favicon/favicon.ico">
    <link rel="apple-touch-icon" href="<?php echo get_template_directory_uri(); ?>/images/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" href="<?php echo get_template_directory_uri(); ?>/images/favicon/android-chrome-192x192.png">

    <!-- font -->
    <script src="https://kit.fontawesome.com/1a4baa9b05.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <?php wp_head(); ?>
</head>

<body>
    <header id="header" class="unselectable">
        
        <?php wp_nav_menu( array(
            'menu'  => 'main-menu', //メニュー管理画面で登録したメニュー名
            'container' => 'nav',
            'container_id' => '',
            'container_class' => 'main-nav',
            'menu_id' => '',
            'menu_class' => '',
            'walker'  => new custom_walker_nav_menu
            )
        ); 

        class custom_walker_nav_menu extends Walker_Nav_Menu {
            function start_lvl(&$output, $depth = 0, $args = array()) {
                $output .= '<button class="dropdown-sub-menu" onclick="toggleMenu(this)"><span class="material-icons"></span></button><ul class="sub-menu">';
            }
            function end_lvl(&$output, $depth = 0, $args = array()) {
                $output .= '</ul>';
            }
        }
        ?>


        <div class="global-header">
            <div class="header__left">
                <a href="<?php echo home_url(); ?>"><img src="<?php echo get_the_logo_img_url();?>" alt=""></a>
            </div>
            <div class="header__right">
				<?php if(get_header_lineat_url() != null): ?>
                    <a href="<?php echo get_header_lineat_url(); ?>" target="_blank" rel="noopener noreferrer">公式LINE</a>
				<?php endif; ?>
                <div class="menu-btn__hamburger" onclick="toggle()">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
        </div>
    </header>