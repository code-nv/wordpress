<?php

add_action('rest_api_init', 'university_like_routes');


function university_like_routes()
{
    register_rest_route('university/v1', 'manage_like', array(
        'methods' => 'POST',
        'callback' => 'create_like',
    ));

    register_rest_route('university/v1', 'manage_like', array(
        'methods' => 'DELETE',
        'callback' => 'delete_like'
    ));
}

function create_like($data)
{
    if (is_user_logged_in()) {
        $professor = sanitize_text_field($data['professorID']);
        $existQuery = new WP_Query(array(
            'author' => get_current_user_id(),
            'post_type' => 'like',
            'meta_query' => array(array(
                'key' => 'liked_professor_id',
                'compare' => '=',
                'value' => $professor
            ))
            ));

        if ($existQuery->found_posts == 0 and get_post_type($professor) == 'professor') {
            return wp_insert_post(array(
                'post_type'=>'like',
                'post_status'=> 'publish',
                'post_title'=> 'like',
                'meta_input' => array(
                    'liked_professor_id'=> $professor
                )
            ));
        } else {
            die("invalid professor id");
        }
    } else {
        die('only logged in users can like professors');
    }
}

function delete_like($data)
{
    $like_ID = sanitize_text_field($data['like']);
    if (get_current_user_id() == get_post_field('post_author', $like_ID) and get_post_type($like_ID) == 'like') {
        wp_delete_post($like_ID, true);
        return 'Like has been deleted';
    } else {
        die('you do not have permission to delete that');
    };
}
