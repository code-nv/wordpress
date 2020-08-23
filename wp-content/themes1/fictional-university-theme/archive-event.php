<?php
get_header();
page_banner(array(
    'title'=>'All Events',
    'subtitle'=>"See what's coming up",
    'photo' => get_theme_file_uri('/images/calendar.jpg')
)); ?>

<div class="container container--narrow page-section">
    <?php
        while (have_posts()){
        the_post();
        get_template_part('template-parts/content','event');
    };
    echo paginate_links();
    ?>
    <hr class="section-break">
    <p>looking for an event that already happened? <a href="<?php echo site_url('/past-events')?>">Check out the past events archive.</a></p>
</div>
<?php
get_footer();
?>