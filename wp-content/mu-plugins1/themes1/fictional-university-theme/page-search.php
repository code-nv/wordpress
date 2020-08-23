<?php

get_header();

// welcome to the loop <3
while (have_posts()) {
    // like an iteration variable, this tells us where to get info for this post
    the_post();
    page_banner(); ?>

<div class="container container--narrow page-section">

<?php
// gives the ID number of the parent page or returns 0 (falsey) if there's no parent
$theParent = wp_get_post_parent_id(get_the_ID());

    // conditional logic for children pages
    if ($theParent) {
        ?>
    <div class="metabox metabox--position-up metabox--with-home-link">
    <p><a class="metabox__blog-home-link" href="<?php echo get_permalink($theParent)?>"><i class="fa fa-home" aria-hidden="true"></i> Back to <?php echo get_the_title($theParent)?></a> <span class="metabox__main"><?php the_title()?></span></p>
    </div>
    <?php
    }
    $checkForChildPage = get_pages(array(
        'child_of'=> get_the_ID()
    ));
    // only show parent/child nav menu if there is a parent / child relationship
    if ($theParent or $checkForChildPage) : ?>
    <div class="page-links">
    <h2 class="page-links__title"><a href="<?php echo get_permalink($theParent)?>"><?php echo get_the_title($theParent)?></a></h2>
    <ul class="min-list">
        <?php
        if ($theParent) {
            $findChildrenOf = $theParent;
        } else {
            $findChildrenOf = get_the_ID();
        }
    // populate the menu with child pages of the page or it's parent page
    wp_list_pages(array(
            'title_li' => null,
            'child_of'=> $findChildrenOf,
            'sort_column' => 'menu_order'
        )); ?>
    </ul>
    </div>
    <?php endif ?>


    <div class="generic-content">
        <!-- change the url at the top of the page. the input is named s because that's the wordpress search slug. the es"c_url is used to improve security -->
<?php get_search_form();?>
    </div>

</div>


<?php
}
get_footer(); ?>