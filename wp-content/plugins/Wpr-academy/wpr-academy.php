<?php

/*
Plugin Name: WPR Academy 
Version: 1.0 
*/

// Plugin URL.
define( 'WPR_URL', untrailingslashit( plugins_url( basename( plugin_dir_path( __FILE__ ) ), basename( __FILE__ ) ) ) );
// Plugin path.
define( 'WPR_PATH', untrailingslashit( plugin_dir_path( __FILE__ ) ) );

function search() {
    search_scripts();
    ob_start(); ?>

    <div id="wpr-filter" class="navigation">
    <select id="regions">
        <option class="active" value="">All Levels</option>
        <?php
        $regions = get_terms( array(
            'taxonomy'   => 'level',
            'hide_empty' => true,
        ) );
        foreach ( $regions as $region ) {
            ?>
            <option value="<?php echo $region->term_id; ?>">
                <?php echo $region->name; ?>
            </option>
            <?php
        }
        ?>
    </select>

    <form action="/" method="get">
            <label for="search"></label>
            <input type="text" name="search" id="search" placeholder="Search">
    </form>


    <?php return ob_get_clean();
}

add_shortcode('shortcode_search', 'search');

add_action( 'wp_ajax_search', 'search_callback' );
add_action( 'wp_ajax_nopriv_search', 'search_callback' );

function search_callback() {
    header( "Content-Type: application/json" );
    $levels = $_GET['level'];
    $people = array();

    $products = 
        array(
            'post_type'   => 'engineers',
            'numberposts' => - 1, 
            'tax_query' => array(
                array(
                    'taxonomy' => 'level',
                    'field' => 'term_id', 
                    'terms' => $levels, 
                )
            )
        );

    $eng = new WP_Query ( $products);

    if ($eng->have_posts()) {
        while ($eng->have_posts()) { 
            $eng->the_post();
                $people[] = array(
                    'title' => get_the_title(),
                    'img_src' => wp_get_attachment_image_src(get_post_thumbnail_id(), 'full' ),
                    'level' => $levels,
                );
        }
        wp_reset_query();
    }  
    echo wp_json_encode($people);
    wp_die();
}

function search_scripts() {
    wp_enqueue_script('search', WPR_URL . '/assets/search.js', array('jquery'), '1.0', true );
    wp_localize_script( 'search', 'WPR', array( 'ajax_url'   => admin_url( 'admin-ajax.php' ),
    'ajax_nonce' => wp_create_nonce( 'search' ) ) );
}

    
    














