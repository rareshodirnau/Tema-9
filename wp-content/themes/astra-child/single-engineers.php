<?php get_header(); ?>

<?php if (have_posts()) {
        while (have_posts()) {
        the_post(); 
        
        $date_of_birth = date_create(get_field('date_of_birth' ));
        $today         = date_create(date('Ymd'));
        $interval      = date_diff($today, $date_of_birth);

?>
        <div class="wpr-post">

            <!-- ACF profile image field --> 
            <!-- <?php
            $image = get_field('profile_image');
            if (!empty($image)): ?>
                        <img class="wpr-image" src="<?php echo esc_url(
                            $image['url']
                        ); ?>" alt="<?php echo esc_attr($image['alt']); ?>" />
            <?php endif;?> -->

            <!-- Engineer Post Thumbnail --> 
            <?php
                    if (has_post_thumbnail()) {
                    $image_src = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
                    echo '<img src="' . $image_src[0] . '" alt=""  />';
                    }
            ?>
            <div class="wpr-desc">
                <?php
                echo '<h1 class="wpr-title"><a href="' . get_permalink() . '">' . get_the_title() . '</a></h1>';
                ?>
                <div class="wpr-bio">
                    <p>Bio: <?php echo the_content(); ?></p>
                    <p>Age: <?php echo $interval->y ?> </p>
                    <?php
                    $featured_posts = get_field('software');
                    if( $featured_posts ): ?>
                        <ul>
                        <?php foreach( $featured_posts as $post ): 
                            setup_postdata($post); ?>
                            <li>
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </li>
                        <?php endforeach; ?>
                        </ul>
                        <?php 
                        wp_reset_postdata(); 
                        ?>
                        <?php endif; ?>
                </div>
            </div>
        </div>    
<?php
    }
} ?>


<?php get_footer(); ?>
