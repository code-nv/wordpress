<?php
get_header();
page_banner(array(
    'title'=>'Past Events',
    'subtitle'=>'Check out what happened way back when'
));
?>

<div class="container container--narrow page-section">
    <?php $pastEvents = new WP_Query(array(
        'post_type'=>'event'
    )); ?>
<?php
    $today = date('Ymd');
    $pastEvents = new WP_Query(array(
        // used to grab the proper posts per the pagination, and if there is none, use 1 as default
        'paged'=> get_query_var('paged', 1),
        'posts_per_page' => 2,
        'post_type' => 'event',
        'orderby'=>'meta_value_num',
        'meta_key' => 'event_date',
        'order'=>'ASC',
        'meta_query'=> array(
            array(
                'key'=> 'event_date',
                'compare' => '<',
                'value' => $today,
                'type'=>'numeric'
            )
        )

    ));
    while ($pastEvents->have_posts()):
        $pastEvents->the_post();
get_template_part('template-parts/content-event');
    endwhile;
// getting pagination with custom pages
echo paginate_links(array(
    'total'=> $pastEvents->max_num_pages
))
?>
</div>
    <?php
get_footer();
