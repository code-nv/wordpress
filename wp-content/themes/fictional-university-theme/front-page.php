<?php

get_header(); ?>
<div class="page-banner">
    <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri('/images/front-page.jpg'); ?>);"></div>
    <div class="page-banner__content container t-center c-white">
        <h1 class="headline headline--large">Welcome!</h1>
        <h2 class="headline headline--medium">There&rsquo;s a lot to explore here.</h2>
        <h3 class="headline headline--small">Feel free to click around and maybe read a blog post or two.</h3>
        <a href="<?php echo get_post_type_archive_link('project')?>" class="btn btn--large btn--blue">or browse my projects</a>
    </div>
    </div>

    <div class="full-width-split group">
    <div class="full-width-split__one">
        <div class="full-width-split__inner">
        <h2 class="headline headline--small-plus t-center">Upcoming Events</h2>
        <?php
        $today = date('Ymd');
        $homepage_events = new WP_Query(array(
            'posts_per_page' => 2,
            'post_type' => 'event',
            'orderby'=>'meta_value_num',
            'meta_key' => 'event_date',
            'order'=>'ASC',
            'meta_query'=> array(
                array(
                    'key'=> 'event_date',
                    'compare' => '>=',
                    'value' => $today,
                    'type'=>'numeric'
                )
            )

        ));
        while ($homepage_events->have_posts()) {
            $homepage_events->the_post();
            get_template_part('template-parts/content', 'event');
        }
        ?>

        <p class="t-center no-margin"><a href="<?php echo get_post_type_archive_link('event')?>" class="btn btn--blue">View All Events</a></p>
        </div>
    </div>
    <div class="full-width-split__two">
        <div class="full-width-split__inner">
        <h2 class="headline headline--small-plus t-center">From My Journalism</h2>
        <?php
        $homepage_posts = new WP_Query(array(
            'posts_per_page'=>2,
        ));
        while ($homepage_posts->have_posts()):
        $homepage_posts->the_post(); ?>
        <div class="event-summary">
            <a class="event-summary__date event-summary__date--beige t-center" href="<?php the_permalink()?>">
            <span class="event-summary__month"><?php the_time('M')?></span>
            <span class="event-summary__day"><?php the_time('d')?></span>
            </a>
            <div class="event-summary__content">
            <h5 class="event-summary__title headline headline--tiny"><a href="<?php the_permalink()?>"><?php the_title()?></a></h5>
            <p><?php if (
                has_excerpt()) {
            echo get_the_excerpt();
        } else {
            echo wp_trim_words(get_the_content(), 18);
        }?> <a href="<?php the_permalink()?>" class="nu gray">Learn more</a></p>
            </div>
        </div>
        <?php
        endwhile;
        // reset info on the query class! good practice
        wp_reset_postdata(); ?>

        <p class="t-center no-margin"><a href="<?php echo site_url('/blog')?>" class="btn btn--yellow">View All Blog Posts</a></p>
        </div>
    </div>
    </div>

    <div class="hero-slider">
    <div data-glide-el="track" class="glide__track">
        <div class="glide__slides">
        <div class="hero-slider__slide" style="background-image: url(<?php echo get_theme_file_uri('/images/newspapers.jpg')?>);">
            <div class="hero-slider__interior container">
            <div class="hero-slider__overlay">
                <h2 class="headline headline--medium t-center">My blog</h2>
                <p class="t-center">I used to write for a college newspaper. Check out some of my articles!</p>
                <p class="t-center no-margin"><a href="<?php echo site_url('/blog')?>" class="btn btn--blue">Learn more</a></p>
            </div>
            </div>
        </div>
        <div class="hero-slider__slide" style="background-image: url(<?php echo get_theme_file_uri('/images/travel.jpg')?>);">
            <div class="hero-slider__interior container">
            <div class="hero-slider__overlay">
                <h2 class="headline headline--medium t-center">My Locations</h2>
                <p class="t-center">I've travelled lots, check out where I learned to code!</p>
                <p class="t-center no-margin"><a href="<?php echo site_url('/locations') ?>" class="btn btn--blue">Learn more</a></p>
            </div>
            </div>
        </div>
        <div class="hero-slider__slide" style="background-image: url(<?php echo get_theme_file_uri('/images/code.jpg')?>);">
            <div class="hero-slider__interior container">
            <div class="hero-slider__overlay">
                <h2 class="headline headline--medium t-center">My Projects</h2>
                <p class="t-center">I'm always expanding my portfolio, learning new languages and skills.</p>
                <p class="t-center no-margin"><a href="<?php echo site_url('/projects')?>" class="btn btn--blue">Learn more</a></p>
            </div>
            </div>
        </div>
        </div>
        <div class="slider__bullets glide__bullets" data-glide-el="controls[nav]"></div>
    </div>
    </div>
<?php get_footer();
?>
