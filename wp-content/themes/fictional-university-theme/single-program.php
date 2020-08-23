<?php
get_header();
page_banner();
while (have_posts()) {
    the_post(); ?>
<div class="container container--narrow page-section">
    <div class="metabox metabox--position-up metabox--with-home-link">
        <p><a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('program')?>"><i class="fa fa-home" aria-hidden="true"></i>All Languages</a> <span class="metabox__main"><?php the_title()?></span></p>
    </div>

<div class="generic-content">
    <?php the_field('main_body_content');

    // related projects
    $related_projects = new WP_Query(array(
        'posts_per_page' => -1,
        'post_type' => 'project',
        'orderby'=>'title',
        'order'=>'ASC',
        'meta_query'=> array(
            array(
                'key'=> 'related_programs',
                'compare'=>'LIKE',
                // the quotations are concat'd on because the above key is serialized and we don't want false positives
                'value'=> '"'.get_the_ID().'"',
            )
        )

    ));
    // only display if there are upcoming events
    if ($related_projects->have_posts()) {
        echo '<h3 class="headline headline--medium">View my '.get_the_title().' projects</h3>';
        echo '<ul class="project-cards">';
        while ($related_projects->have_posts()) {
            $related_projects->the_post(); ?>
    <li class="project-card__list-item">
        <a class="project-card" href="<?php the_permalink(); ?>">
        <img class="project-card__image" src="<?php the_post_thumbnail_url('project_landscape')?>" alt="">
        <span class="project-card__name"> <?php the_title()?></span>
    </a>
</li>
        <?php
        }
        echo '</ul>';
    }
    // reset the global 'posts' object to allow the next query to have a proper ID
    wp_reset_postdata();

    // related programs
    $today = date('Ymd');
    $homepage_events = new WP_Query(array(
        'posts_per_page' => 2,
        'post_type' => 'event',
        'orderby'=>'meta_value_num',
        'meta_key' => 'event_date',
        'order'=>'ASC',
        'meta_query'=> array(
            array(
                'key'=> 'event_date',
                'compare' => '>=',
                'value' => $today,
                'type'=>'numeric'
            ),
            array(
                'key'=> 'related_programs',
                'compare'=>'LIKE',
                // the quotations are concat'd on because the above key is serialized and we don't want false positives
                'value'=> '"'.get_the_ID().'"',
            )
        )

    ));
    // only display if there are upcoming events
    if ($homepage_events->have_posts()) {
        echo '<hr class="section-break">';
        echo '<h3 class="headline headline--medium">Upcoming '.get_the_title().' Events</h3>';
        while ($homepage_events->have_posts()) {
            $homepage_events->the_post();
            get_template_part('template-parts/content', 'event');
        }
    }
    // clean slate then grab related locations to show relationship on front end
    wp_reset_postdata();
    $related_locations = get_field('related_locations');
    if ($related_locations) {
        echo '<hr class="section-break">';
        echo '<h3 class="headline headline--medium">'.get_the_title().' was learned here!</h3>';
        echo '<ul class="min-list link-list">';
        foreach ($related_locations as $location) {
            ?> <li><a href="<?php echo get_the_permalink($location)?>"><?php echo get_the_title($location)?></a></li>
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