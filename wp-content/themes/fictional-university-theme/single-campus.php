<?php
get_header();
page_banner();
while (have_posts()) {
    the_post(); ?>
<div class="container container--narrow page-section">
    <div class="metabox metabox--position-up metabox--with-home-link">
        <p><a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('campus')?>"><i class="fa fa-home" aria-hidden="true"></i>All Campuses</a> <span class="metabox__main"><?php the_title()?></span></p>
    </div>

<div class="generic-content"> <?php the_content(); ?>
<div class="acf-map">
        <?php
        $map_location = get_field('map_location'); ?>
                <div class="marker" data-lat="<?php echo $map_location['lat']?>" data-lng="<?php echo $map_location['lng']?>">
                    <h3><?php the_title(); ?></h3>
                    <?php echo $map_location['address']?>
                </div>
</div>
<?php
    // related professors
    $related_programs = new WP_Query(array(
        'posts_per_page' => -1,
        'post_type' => 'program',
        'orderby'=>'title',
        'order'=>'ASC',
        'meta_query'=> array(
            array(
                'key'=> 'related_campuses',
                'compare'=>'LIKE',
                'value'=> '"'.get_the_ID().'"',
            )
        )

    ));
    // only display if there are upcoming events
    if ($related_programs->have_posts()) {
        echo '<hr class="section-break">';
        echo '<h2 class="headline headline--medium">Programs Available at this Campus</h2>';
        echo '<ul class="min-list link-list">';
        while ($related_programs->have_posts()) {
            $related_programs->the_post(); ?>
    <li>
        <a href="<?php the_permalink(); ?>"> <?php the_title();?>
    </a>
</li>
        <?php
        }
        echo '</ul>';
    } ?>

</div>
</div>
<?php
    // like the count variable and tells us where to get info for this post
}
get_footer();
?>