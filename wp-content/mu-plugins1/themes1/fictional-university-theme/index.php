<?php
get_header();
page_banner(array(
    'title'=>'Welcome to my blog',
    'subtitle'=>'These are some articles I wrote for the paper!',
    'photo' => get_theme_file_uri('/images/newspapers.jpg')
));
?>

<div class="container container--narrow page-section">
<?php
    while (have_posts()):
    the_post(); ?>
<div class="post-item">
    <h2 class="headline headline--medium headline--post-title"><a href="<?php echo the_permalink()?>"><?php the_title()?></a></h2>
    <div class="metabox">
        <p>posted by: <?php the_author_posts_link()?> on: <?php the_time('n.j.y')?> in <?php echo get_the_category_list(', ')?></p>
    </div>
    <div class="generic-content">
        <?php the_excerpt()?>
        <p>
            <a class="btn btn--blue" href="<?php the_permalink()?>">Continue reading &raquo;</a>
        </p>
    </div>
</div>
<?php
    endwhile;
    echo paginate_links();
?>
</div>
    <?php
get_footer();
