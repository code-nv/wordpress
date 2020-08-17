<?php
// import logic from another php file. trying to keep functions.php clean
require get_theme_file_path('/inc/search-route.php');
require get_theme_file_path('/inc/like-route.php');

// custom wp api response
function university_custom_rest()
{
    register_rest_field('post', 'author_name', array(
'get_callback'=> function () {
    return get_the_author();
}
));

register_rest_field('note', 'user_note_count', array(
    'get_callback'=> function () {
        return count_user_posts(get_current_user_id(),'note');
    }
    ));

}

add_action('rest_api_init', 'university_custom_rest');

function page_banner($args = null)
{
    if (!$args['title']) {
        $args['title'] = get_the_title();
    }
    if (!$args['subtitle']) {
        $args['subtitle'] = get_field('page_banner_subtitle');
    }
    if (!$args['photo']) {
        if (get_field('page_banner_background_image')) {
            $args['photo'] = get_field('page_banner_background_image')['sizes']['page_banner'];
        } else {
            $args['photo'] = get_theme_file_uri('/images/ocean.jpg');
        }
    } ?>

<div class="page-banner">
    <div class="page-banner__bg-image" style="background-image: url(<?php echo $args['photo'] ?>"></div>
    <div class="page-banner__content container container--narrow">
    <h1 class="page-banner__title"><?php echo $args['title']?></h1>
    <div class="page-banner__intro">
        <p><?php echo $args['subtitle']?></p>
    </div>
    </div>  
</div>

    <?php
}

function university_files()
{
    wp_enqueue_style('font_awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
    wp_enqueue_style('google_fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
    // google maps API JS logic
    wp_enqueue_script('google_map', '//maps.googleapis.com/maps/api/js?key=AIzaSyBwSTYu5ShZR1NA9DV9MAoxUUdlCtowiTM', null, '1.0', true);

    // adjust bundled assets for online/offline workspace
    if (strstr($_SERVER['SERVER_NAME'], 'fictional-university.locall')) {
        wp_enqueue_script('main_university_js', 'http://localhost:3000/bundled.js', null, '1.0', true);
    } else {
        wp_enqueue_script('our_venders_js', get_theme_file_uri('/bundled-assets/vendors~scripts.9678b4003190d41dd438.js'), null, '1.0', true);
        wp_enqueue_script('main_university_js', get_theme_file_uri('/bundled-assets/scripts.bf57a83c55e3fd47bc10.js'), null, '1.0', true);
        wp_enqueue_style('our_main_styles', get_theme_file_uri('/bundled-assets/styles.bf57a83c55e3fd47bc10.css'));
    }

    // name of file to make flexible, variable name, array of data we want available
    // you can view this response on the source html page source
    wp_localize_script('main_university_js', 'university_data', array(
'root_url'=>get_site_url(),
'nonce' => wp_create_nonce('wp_rest')
));
}
add_action('wp_enqueue_scripts', 'university_files');

function university_features()
{
    register_nav_menu('footer_menu_location_one', 'Footer Location One');
    register_nav_menu('footer_menu_location_two', 'Footer Location Two');
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_image_size('project_landscape', 400, 260, true);
    add_image_size('project_portrait', 480, 650, true);
    add_image_size('page_banner', 1500, 350, true);
}

add_action('after_setup_theme', 'university_features');

function university_adjust_queries($query)
{
    // will prevent from adjusting admin side, will only affect even archive, and has safety check to make sure it's not adjusting other custom queries
    if (!is_admin() and is_post_type_archive('program') and $query->is_main_query()) {
        $query->set('orderby', 'title');
        $query->set('order', 'ASC');
        $query->set('posts_per_page', -1);
    }

    if (!is_admin() and is_post_type_archive('location') and $query->is_main_query()) {
        $query->set('posts_per_page', -1);
    }

    if (!is_admin() and is_post_type_archive('event') and $query->is_main_query()) {
        $today = date('Ymd');
        $query->set('meta_key', 'event_date');
        $query->set('orderby', 'meta_value_num');
        $query->set('order', 'ASC');
        $query->set(
            'meta_query',
            array(
                array(
                    'key'=> 'event_date',
                    'compare' => '>=',
                    'value' => $today,
                    'type'=>'numeric'
                    )
                )
        );
    }
}

add_action('pre_get_posts', 'university_adjust_queries');

function university_map_key($api)
{
    $api['key'] = 'AIzaSyBwSTYu5ShZR1NA9DV9MAoxUUdlCtowiTM';
    return $api;
}

add_filter('acf/fields/google_map/api', 'university_map_key');

// redirect subscribers to homepage

add_action('admin_init', 'redirect_subscribers');

function redirect_subscribers()
{
    $current_user = wp_get_current_user();
    if (count($current_user->roles) == 1 and $current_user->roles[0] == 'subscriber') {
        wp_redirect(site_url('/'));
        exit;
    }
}

add_action('wp_loaded', 'hide_admin_bar');

function hide_admin_bar()
{
    $current_user = wp_get_current_user();
    if (count($current_user->roles) == 1 and $current_user->roles[0] == 'subscriber') {
        show_admin_bar(false);
    }
}

// customize login screen

add_filter('login_headerurl', 'custom_header_url');

function custom_header_url()
{
    return esc_url(site_url());
}

add_action('login_enqueue_scripts', 'custom_login_css');

function custom_login_css()
{
    wp_enqueue_style('our_main_styles', get_theme_file_uri('/bundled-assets/styles.bf57a83c55e3fd47bc10.css'));
    wp_enqueue_style('font_awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
}
add_filter('login_headertitle', 'custom_login_title');

function custom_login_title()
{
    return get_bloginfo('name');
}

// force note posts to be private as safety measure
// 10 is the default priority
// 2 lets the filter know we're passing 2 parameters
add_filter('wp_insert_post_data', 'make_note_private',10,2);

function make_note_private($data, $postarr)
{
    if ($data['post_type'] == 'note') {
        // check how many note posts this user has created
        // the second parameter is used to check that this action is trying to create a new post
        if (count_user_posts(get_current_user_id(), 'note') > 5 and !$postarr['ID'] ) {
            die("you have reached your note limit");
        }
        if (!$data['post_content'] || !$data['post_title']) {
            die("please fill out your note");
        }
        // this is an additional security measure to strip html
        // $data['post_content'] = sanitize_textarea_field($data['post-content']);
        // $data['post_title'] = sanitize_text_field($data['post-title']);
    }
    if ($data['post_type'] == 'note' and $data['post_status'] != 'trash') {
        $data['post_status'] = "private";
    }
    return $data;
}
