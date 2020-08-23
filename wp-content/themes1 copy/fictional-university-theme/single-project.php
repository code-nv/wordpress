<?php
get_header();
while (have_posts()) {
    the_post();
    page_banner(); ?>

<div class="container container--narrow page-section">
<div class="metabox metabox--position-up metabox--with-home-link">
        <p><a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('project')?>"><i class="fa fa-home" aria-hidden="true"></i>All Projects</a> <span class="metabox__main"><?php the_title()?></span></p>
    </div>
<div class="generic-content">
    <div class="row group">
        <div class="one-third">
<?php the_post_thumbnail('project_portrait')?>
        </div>
        <div class="two-thirds">
<?php
$likeCount = new WP_Query(array(
    'post_type' => 'like',
    'meta_query' => array(array(
        'key' => 'liked_project_id',
        'compare' => '=',
        'value' => get_the_ID()
    ))
    ));
    $existStatus = 'no';
    if (is_user_logged_in()) {
        $existQuery = new WP_Query(array(
            'author' => get_current_user_id(),
            'post_type' => 'like',
            'meta_query' => array(array(
                'key' => 'liked_project_id',
                'compare' => '=',
                'value' => get_the_ID()
            ))
            ));
            
        if ($existQuery->found_posts) {
            $existStatus = 'yes';
        }
    } ?>

            <span class="like-box" data-like="<?php echo $existQuery->posts[0]->ID; ?>" data-project="<?php the_ID()?>" data-exists="<?php echo $existStatus ?>">
                <i class="fa fa-heart-o" aria-hidden="true"></i>
                <i class="fa fa-heart" aria-hidden="true"></i>
                <span class="like-count"><?php echo $likeCount->found_posts?></span>
            </span>
            <?php the_content()?>
        </div>
    </div>

</div>
<?php
$related_subjects = get_field('related_programs');
    if ($related_subjects) {
        echo '<hr class="section-break">';
        echo '<h2 class="headline headline--medium"> Skills Used</h2>';
        echo '<ul class="link-list min-list">';
        foreach ($related_subjects as $subject) { ?>
<li><a href="<?php echo get_the_permalink($subject)?>"><?php echo get_the_title($subject);?></a></li>

<?php }
        echo '</ul>';
    } ?>
</div>
<?php
}
get_footer();
?>