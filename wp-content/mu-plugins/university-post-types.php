<?php
function university_post_types()
{
    // Location Post Type
    register_post_type('location', array(
        'capability_type'=> 'location',
        'map_meta_cap'=>true,
        'public' => true,
        'show_in_rest'=>true,
        'supports' =>(array(
            'title','editor','excerpt',
        )),
        'has_archive' => true,
        'rewrite' => array('slug'=>'locations'),
        'labels'=> array(
            'name'=>'Locations',
            'add_new_item'=>'Add New Location',
            'edit_item'=>'Edit Location',
            'all_items'=>'All Locations',
            'singular_name'=>'Location'
        ),
        'menu_icon'=> 'dashicons-location-alt',
    ));

    // creating event post type
    register_post_type('event', array(
        'capability_type'=>'event',
        'map_meta_cap'=>true,
        'public' => true,
        'show_in_rest'=>true,
        'supports' =>(array(
            'title','editor','excerpt',
        )),
        'has_archive' => true,
        'rewrite' => array('slug'=>'events'),
        'labels'=> array(
            'name'=>'Events',
            'add_new_item'=>'Add New Event',
            'edit_item'=>'Edit Event',
            'all_items'=>'All Events',
            'singular_name'=>'Event'
        ),
        'menu_icon'=> 'dashicons-calendar',
    ));

    // creating program post type
    register_post_type('program', array(
        'public' => true,
        'show_in_rest'=>true,
        'supports' =>(array(
            'title',
        )),
        'has_archive' => true,
        'rewrite' => array('slug'=>'languages'),
        'labels'=> array(
            'name'=>'Languages',
            'add_new_item'=>'Add New Language',
            'edit_item'=>'Edit Language',
            'all_items'=>'All Languages',
            'singular_name'=>'Language'
        ),
        'menu_icon'=> 'dashicons-awards',
    ));

    // creating project post type
    register_post_type('project', array(
        'public' => true,
        'show_in_rest'=>true,
        'has_archive'=> true,
        'rewrite' => array('slug'=>'projects'),
        'supports' =>(array(
            'title','editor', 'thumbnail'
        )),
        'labels'=> array(
            'name'=>'Projects',
            'add_new_item'=>'Add New Project',
            'edit_item'=>'Edit Project',
            'all_items'=>'All Projects',
            'singular_name'=>'Project'
        ),
        'menu_icon'=> 'dashicons-welcome-learn-more',
    ));

    register_post_type('note', array(
        'capability_type'=>'note',
        'public' => false,
        'show_ui' => true,
        'show_in_rest'=>true,
        'map_meta_cap'=>true,
        'supports' =>(array(
            'title','editor',
        )),
        'labels'=> array(
            'name'=>'Notes',
            'add_new_item'=>'Add New Note',
            'edit_item'=>'Edit Note',
            'all_items'=>'All Notes',
            'singular_name'=>'Note'
        ),
        'menu_icon'=> 'dashicons-welcome-write-blog',
    ));

    register_post_type('like', array(
        'supports' =>(array('title')),
        'public' => false,
        'show_ui' => true,
        'labels'=> array(
            'name'=>'likes',
            'add_new_item'=>'Add New like',
            'edit_item'=>'Edit like',
            'all_items'=>'All likes',
            'singular_name'=>'like'
        ),
        'menu_icon'=> 'dashicons-heart',
    ));
}

add_action('init', 'university_post_types');
