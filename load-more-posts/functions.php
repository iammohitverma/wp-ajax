<?php

// load more posts functionality for news and resources posts listing page
function load_more_posts_news_resources()
{
    $args = array(
        'post_type' => 'newsresources',
        'posts_per_page' => 3,
        'offset'        => $_POST['paged'],
    );
    $ajaxposts = new WP_Query($args);

    $post_html = '';

    if ($ajaxposts->have_posts()) {
        while ($ajaxposts->have_posts()) {
            $ajaxposts->the_post();

            $url = get_the_permalink();
            $postThumbUrl = get_the_post_thumbnail_url();
            $date = get_the_date('d-m-Y');
            $the_title = get_the_title();
            $the_excerpt = get_the_excerpt();
            $email_option_news_resources = get_field('email_option_news_resources');
            $show_contact = '';
            if ($email_option_news_resources) {
                $show_contact = '
            <div class="contact">
                <p>contact</p> 
                <a href="mailto:' . $email_option_news_resources . '">
                    ' . $email_option_news_resources . '
                </a>
            </div>';
            } else {
                $show_contact = '';
            }

            $post_html .= '<div class="col-12 col-sm-6 col-lg-4">
            <div class="tm-event-box">
                <div class="img-box">
                    <img src="' . $postThumbUrl . '" alt="' . $the_title . '" />
                </div>
                <div class="text-box">
                    <div class="top">
                        <p>' . $date . '</p>
                        <h4>' . $the_title . '</h4>
                    </div>
                    <div class="middle">
                        <p>' . $the_excerpt . '</p>
                    </div>
                    <div class="bottom">
                        <a href="' . $url . '" class="btn">View</a>' .
                $show_contact
                . '</div>
                </div>
            </div>
        </div>';
            // var_dump($ajaxposts->the_post());
            // $response .= get_template_part('parts/card', 'newsresources');
        }
    } else {
        $post_html = '';
    }

    echo $post_html;

    exit();
}
add_action('wp_ajax_load_more_posts_news_resources', 'load_more_posts_news_resources');
add_action('wp_ajax_nopriv_load_more_posts_news_resources', 'load_more_posts_news_resources');
