<?php get_header(); 

while ( have_posts() ) {
    the_post(); 
    $license = get_field( 'license_validity' );
    $price   = get_field( 'price' );

    $wpr_options = get_option( 'wpr_option' );
    $has_discount = false; 
    $discount_price = 0;

    if ( !empty($wpr_options) ) {
        if ( isset( $wpr_options[ 'wpr_software_discount' ] ) && !empty( $wpr_options[ 'wpr_software_discount' ] ) ){
            if ( isset( $wpr_options ['wpr_discount_period'] ) && !empty( $wpr_options[ 'wpr_discount_period' ] ) ) {
                    $date_created = strtotime(get_the_date());
                    $date_discount_expired = strtotime('+' . $wpr_options ['wpr_discount_period'] . ' days', $date_created);
                    if ($date_discount_expired >= strtotime("now")) {
                        $has_discount = true;
                        $discount_price = doubleval($price) - doubleval($price) * intval( $wpr_options[ 'wpr_software_discount' ] ) / 100 ;
                    }  
            }   
        }
    } 
?>

        <div class="wpr-post">
                <?php
                echo '<h1 class="wpr-title"><a href="' . get_permalink() . '">' . get_the_title() . '</a></h1>';
                ?>
            <div class="wpr-desc">
                <div class="wpr-bio">
                    <p>Description: <?php echo the_content(); ?></p>
                    <p>License validity: <?php echo esc_attr( $license ); ?> Days</p>

                    <?php 
                    if ( $has_discount === true ) {
                        ?>
                        <p>Price (discounted): <?php echo esc_attr( $discount_price ); ?> EUR</p>
                    <?php
                    }
                    else {
                        ?>
                        <p>Price : <?php echo esc_attr( $price ); ?> EUR</p>   
                    <?php
                    }
                    ?>
<p> <?php
    $engineers = new WP_Query(array(
            'post_type'   => 'engineers',
            'post_status' => 'publish', 
            'meta_query'  => array(
            array(
                'key'   => 'software', 
                'value' => '"' . get_the_ID() .'"', 
                'compare' => 'LIKE',
            ), 
            array(
                'key' => 'date_of_birth',
                'value' => date("Ymd", strtotime('- 25 years')),
                'compare' => '<=',
                )
            )
            
        ));
        if ($engineers->have_posts()) {
            ?>
            <ul>
            <?php
                while ($engineers->have_posts()) {
                    $engineers->the_post();
                    ?>
                <li><?php the_title(); ?></li>
                <?php 
                }
                ?>
            </ul>
        <?php
        }
        ?>
<?php   
wp_reset_postdata();
?>
</p>
                </div>
            </div>
        </div>   

        <?php
    }
?>

<?php get_footer(); ?>