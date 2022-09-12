<?php
get_header(); ?>

<?php if (have_posts()) {
        
    echo do_shortcode('[shortcode_search]');
        echo '<div id="archive-engineers">';
    while (have_posts()) {
        the_post(); ?>
        <div class="wpr-post">

    <!-- ACF profile image field -->    
    <!-- <?php
    $image = get_field('profile_image');
    if (!empty($image)): ?>
                <img class="wpr-image" src="<?php echo esc_url(
                    $image['url']
                ); ?>" alt="<?php echo esc_attr($image['alt']); ?>" />
                <?php endif; 
    ?> -->

    <!-- Engineer Post Thumbnail --> 
    <?php
			if (has_post_thumbnail()) {
			$image_src = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
			echo '<img src="' . $image_src[0] . '" alt=""  />';
			}
	?>
    <?php echo '<h1 class="wpr-title"><a href="' . get_permalink() . '">' . get_the_title() . '</a></h1>';
    ?>
    </div>    
<?php
    }
    echo '</div>';
} ?>


<?php get_footer(); ?>

