<?php
get_header();
page_banner(array(
    'title'=>'Search Results',
    // some security measures here, when printing out user input. esc_html will prevent the input from registering as html elements. the 'false' argument in get_search_query is disabling it's initial safety protocol to opt for this more explicit safety.
    'subtitle'=>'You searched for &ldquo;'. esc_html(get_search_query(false)) .'&ldquo;'
));
?>

<div class="container container--narrow page-section">
<?php
if(have_posts()){
    while (have_posts()):
        echo the_post(); 
    
        get_template_part('template-parts/content', get_post_type());
        endwhile;
        echo paginate_links();
} else {
    echo '<h2 class="headline headline--small-plus">no results matched that search</h2>';
}
get_search_form();
    
?>
</div>
    <?php
get_footer();
