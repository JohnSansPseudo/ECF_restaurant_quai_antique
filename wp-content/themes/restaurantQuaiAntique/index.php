<?php
/*<?php bloginfo('name'); ?>*/


?>
<?php get_header() ?>

    <div class="row">

        <div class="col sm-3"></div>
        <div class="col sm-9"><?php the_title(); ?></div>

    </div>
    <div class="row">
        <?php the_content(); ?>
    </div>

<?php get_footer() ?>