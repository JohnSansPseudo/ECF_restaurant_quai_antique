<?php

//MENU
$aMenuArgs = array(
    'theme_location' => 'header',
    'menu_class' => 'navbar-nav mb-2 mb-lg-0',
    'container' => false,
    'walker' => '');

//LOGO
$custom_logo_id = get_theme_mod( 'custom_logo' );
$image = wp_get_attachment_image_src( $custom_logo_id , 'full' );

// bloginfo('name');

?>
<!DOCTYPE HTML>
<html lang="fr">
<head>
    <meta charset="<? bloginfo('charset'); ?>">
    <?php wp_head(); ?>
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg">
            <div class="container">
                <a class="navbar-brand" href="<?php bloginfo('wpurl');?>">
                    <img src="<?php  echo $image[0] ?>" alt="logo" class="">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mb-2 mb-lg-0">
                        <?php wp_nav_menu($aMenuArgs); ?>
                    </ul>
                    <a href="" class="btn btnSaillance" id="">Réserver votre table</a>
                </div>
            </div>
        </nav>
    </header>
    <div class="container">