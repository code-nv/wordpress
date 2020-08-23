<?php

function university_register_search()
{

    // versioning is good future proofing
    // replace later
    register_rest_route('university/v1', 'search', array(
        'method'=> WP_REST_SERVER::READABLE,
        'callback'=> 'university_search_results'
    ));
}

function university_search_results($data)
{
    $main_query = new WP_Query(array(
    'post_type'=>array('post','page','project','program','event','locations'),
    's' => sanitize_text_field($data['term'])
));

    $results = array(
        'general_info' => array(),
        'projects' => array(),
        'programs' => array(),
        'events' => array(),
        'locations' => array()
    );

    while ($main_query->have_posts()) {
        $main_query->the_post();
        if (get_post_type()=='post' or get_post_type()=='page') {
            array_push(
                $results['general_info'],
                array(
            'title' => get_the_title(),
            'permalink' => get_permalink(),
            'post_type'=>get_post_type(),
            'author_name'=>get_the_author(),
            )
            );
        }
        if (get_post_type()=='project') {
            array_push(
                $results['projects'],
                array(
            'title' => get_the_title(),
            'permalink' => get_permalink(),
            'image'=> get_the_post_thumbnail_url(0, 'project_landscape'),
            )
            );
        }
        if (get_post_type()=='program') {
            $related_locations = get_field('related_locations');
            if($related_locations){
                foreach($related_locations as $location){
array_push($results['locations'], array(
    'title'=> get_the_title($location),
    'permalink'=> get_the_permalink($location),
));
                }
            }
            array_push(
                $results['programs'],
                array(
            'title' => get_the_title(),
            'permalink' => get_permalink(),
            'id'=> get_the_ID(),
            )
            );
        }
        if (get_post_type()=='locations') {
            array_push(
                $results['locations'],
                array(
            'title' => get_the_title(),
            'permalink' => get_permalink(),
            )
            );
        }
        if (get_post_type()=='event') {
            $event_date = new DateTime(get_field('event_date'));
            $description = null;
            if (
                has_excerpt()) {
                $description = get_the_excerpt();
            } else {
                $description = wp_trim_words(get_the_content(), 18);
            }
            array_push(
                $results['events'],
                array(
            'title' => get_the_title(),
            'permalink' => get_permalink(),
            'month'=>$event_date->format('M'),
            'day'=>$event_date->format('d'),
            'description'=> $description
            )
            );
        }
    }

    if ($results['programs']) {
        $programs_meta_query = array('relation'=> 'OR');

        foreach ($results['programs'] as $item) {
            array_push($programs_meta_query, array(
            'key'=> 'related_programs',
            'compare'=> 'LIKE',
            'value'=> '"' .$item['id'] . '"'
        ));
        }

        $program_relationship_query = new WP_Query(array(
    'post_type'=>array('project','event'),
    'meta_query'=>array($programs_meta_query)
));
        while ($program_relationship_query->have_posts()) {
            $program_relationship_query->the_post();

            if (get_post_type()=='project') {
                array_push(
                    $results['projects'],
                    array(
        'title' => get_the_title(),
        'permalink' => get_permalink(),
        'image'=> get_the_post_thumbnail_url(0, 'project_landscape'),
        )
                );
            }
            if (get_post_type()=='event') {
                $event_date = new DateTime(get_field('event_date'));
                $description = null;
                if (
                    has_excerpt()) {
                    $description = get_the_excerpt();
                } else {
                    $description = wp_trim_words(get_the_content(), 18);
                }
                array_push(
                    $results['events'],
                    array(
                'title' => get_the_title(),
                'permalink' => get_permalink(),
                'month'=>$event_date->format('M'),
                'day'=>$event_date->format('d'),
                'description'=> $description
                )
                );
            }
        }
        // eliminate duplicate results and prevent the array unique function from adding number indexes.
        $results['projects'] = array_values(array_unique($results['projects'], SORT_REGULAR));
        $results['events'] = array_values(array_unique($results['events'], SORT_REGULAR));
        $results['locations'] = array_values(array_unique($results['locations'], SORT_REGULAR));
    }
    return $results;
}

add_action('rest_api_init', 'university_register_search');
