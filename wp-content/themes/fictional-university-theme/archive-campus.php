<?php
get_header();
page_banner(array(
    'title'=>'Our Campuses',
    'subtitle'=>"Our Campuses do not make sense, we're doing our best",
));
?>

<div class="container container--narrow page-section">
    <div class="acf-map">
        <?php
            while (have_posts()) {
                the_post();
                $map_location = get_field('map_location'); ?>
                <div class="marker" data-lat="<?php echo $map_location['lat']?>" data-lng="<?php echo $map_location['lng']?>">
                    <a href="<?php the_permalink()?>"><h3><?php the_title(); ?></h3></a>
                    <?php echo $map_location['address']?>
                </div>
<?php }; ?>
</div>


</div>
    <?php
get_footer();
