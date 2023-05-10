<?php
/**
 * Template Name: News and Resources
 * The template for News and Resources page
 **/

get_header();
?>

<div class="" id="page-<?php echo sanitize_title_with_dashes(get_the_title()); ?>">
    <?php the_content(); ?>

    

    <section class="tm-events-listing-wrap">
        <div class="container">
            <div class="row listing-row">
            <?php
                $args = array(
                    'post_type'      => 'newsresources',
                    'posts_per_page' => 3,
                );
                $loop = new WP_Query($args);
                while ( $loop->have_posts() ) {
                    $loop->the_post();
                    ?>
                    <div class="col-12 col-sm-6 col-lg-4">
                        <div class="tm-event-box">
                            <div class="img-box">
                                <?php the_post_thumbnail('full'); ?>
                            </div>
                            <div class="text-box">
                                <div class="top">
                                    <p><?php echo get_the_date( 'd-m-Y' );  ?></p>
                                    <h4><?php echo the_title();?></h4>
                                </div>
                                <div class="middle">
                                    <p><?php echo get_the_excerpt();?></p>
                                </div>
                                <div class="bottom">
                                    <a href="<?php the_permalink(); ?>" class="btn">View</a>
                                    <?php
                                      $email_option_news_resources = get_field('email_option_news_resources');   
                                      if($email_option_news_resources){
                                        ?>
                                            <p>contact</p> 
                                            <a href="mailto:<?php echo $email_option_news_resources?>"><?php echo $email_option_news_resources?></a>
                                        <?php
                                      }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                }
            ?>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="btn-wrapper">
                        <span class="post-loader">
                            <img src="/wp-content/themes/boldpark/assets/images/loader.gif" alt="loader">
                        </span>
                        <button id="load-more-posts" class="load-more">Load more</button>
                        <p class="no-post-message">There are no more posts to show right now.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        // Load more news more posts
        let currentPage = 1;
        jQuery('#load-more-posts').on('click', function() {
            $posts_display = 3 * currentPage;
            
            $('.post-loader').show();
            
            // We will do our magic here soon!
            currentPage++; // Do currentPage + 1, because we want to load the next 
            
            jQuery.ajax({
                type: 'POST',
                url: '/wp-admin/admin-ajax.php',
                dataType: 'html',
                data: {
                action: 'load_more_posts_news_resources',
                paged: $posts_display,
            },
                success: function (res) {
                    if(res != ''){
                        $('.post-loader').hide();
                        $('.tm-events-listing-wrap .row.listing-row').append(res);
                    }else{
                        $('.post-loader').hide();
                        $('#load-more-posts').hide();
                        $('.no-post-message').show();
                    }
                }
            });
        });
    </script>
</div>

<?php
get_footer();