<?php




// Add custom style in child theme
function wpr_add_style()
{
    wp_enqueue_style(
        'wpr-academy-style',
        get_stylesheet_directory_uri() . '/assets/css/style.css',
    );
	
	wp_enqueue_script(
        'wpr-academy-style',
        get_stylesheet_directory_uri() . '/assets/js/quick.js', array('jquery'), 1, 'all'
    );
}
add_action('wp_enqueue_scripts', 'wpr_add_style');

// Create CPT Engineers
function engineers()
{
    $taxargs = array (
        'labels' =>  array (
        'name'              => __( 'Level', '' ),
        'singular_name'     => __( 'Level', '' ),
        'search_items'      => __( 'Search Level', '' ),
        'all_items'         => __( 'All Levels', '' ),
        'parent_item'       => __( 'Parent Level', '' ),
        'parent_item_colon' => __( 'Parent Level:', '' ),
        'edit_item'         => __( 'Edit Level', '' ),
        'update_item'       => __( 'Update Level', '' ),
        'add_new_item'      => __( 'Add New Level', '' ),
        'new_item_name'     => __( 'New Level', '' ),
        ), 
        'hierarchical'      => true,
        'show_ui'           => true,
        'show_admin_column' => true,
        'show_in_rest'      => true, 
        'query_var'         => true, 
        'rewrite'           => array( 
            'slug' => 'level', 
        ),
        'public' => true,
    );
    register_taxonomy( 'level', array('level'), $taxargs);
    
    $args = [
        'label'               => __( 'Engineers', '' ),
        'labels' => [
            'name' => __('Engineers'),
            'singular_name' => __('Engineer'),
            'add_new_item' => __('Add engineer'),
            'add_new' => __('Add engineer'),
            'edit_item' => __('Edit engineer'),
        ],
        'hierarchical' => true,
        'public' => true,
        'has_archive' => true,
        'menu_icon' => 'dashicons-admin-users',
        'supports' => ['title', 'editor', 'thumbnail', 'custom-fields'],
        'show_in_rest' => true,
        'menu_position'       => 4,
        'taxonomies'     => array( 'level' ), 

    ];
    register_post_type('engineers', $args);
}
add_action('init', 'engineers');

// Create CPT Software
function software()
{
    $taxargs = array (
        'labels' =>  array (
        'name'              => __( 'Country', '' ),
        'singular_name'     => __( 'Country', '' ),
        'search_items'      => __( 'Search Country', '' ),
        'all_items'         => __( 'All Countries', '' ),
        'parent_item'       => __( 'Parent Country', '' ),
        'parent_item_colon' => __( 'Parent Country:', '' ),
        'edit_item'         => __( 'Edit Country', '' ),
        'update_item'       => __( 'Update Country', '' ),
        'add_new_item'      => __( 'Add New Country', '' ),
        'new_item_name'     => __( 'New Country', '' ),
        ), 
        'hierarchical'      => true,
        'show_ui'           => true,
        'show_admin_column' => true,
        'show_in_rest'      => true, 
        'query_var'         => true, 
        'rewrite'           => array( 
            'slug' => 'country', 
        ),
    );
    register_taxonomy( 'country', array('country'), $taxargs);

    $args = [
        'label'               => __( 'Software', '' ),
        'labels' => [
            'name' => __('Software'),
            'singular_name' => __('Software'),
            'add_new_item' => __('Add software'),
            'add_new' => __('Add software'),
            'edit_item' => __('Edit software'),
        ],
        'hierarchical'   => true,
        'public'         => true,
        'has_archive'    => false,
        'menu_icon'      => 'dashicons-analytics',
        'supports'       => ['title', 'editor', 'thumbnail', 'custom-fields'],
        'show_in_rest'   => true,
        'menu_position'  => 5,
        'taxonomies'     => array( 'country' ), 
    ];
    register_post_type('software', $args);
}
add_action('init', 'software');

function api_fields_callback($args) {
	?>
	<p id="<?php echo esc_attr( $args['id'] ); ?>"><?php esc_html_e( 'Edit WPR API Settings.', 'wpr' ); ?></p>
	<?php
}

function software_discount_fields_callback($args) {
	?>
	<p id="<?php echo esc_attr( $args['id'] ); ?>"><?php esc_html_e( 'Edit Software Discount', 'wpr' ); ?></p>
	<?php
}

add_action(
	'admin_init',
	function() {

		register_setting( 'wpr_academy', 'wpr_option' );

        add_settings_section(
			'API_Fields',
			'API Fields',
            'api_fields_callback',
			'wpr_academy',
		);

		add_settings_field(
			'wpr_api_token',
			'Api Token',
			'api_field_callback',
			'wpr_academy',
			'API_Fields',
			array(
				'label_for'       => 'wpr_api_token',
				'class'           => 'wpr_row',
				'wpr_custom_data' => 'custom',
			)
		);

        add_settings_field(
			'wpr_client_id',
			'Client ID',
			'client_id_field_callback',
			'wpr_academy',
			'API_Fields',
			array(
				'label_for'       => 'wpr_client_id',
				'class'           => 'wpr_row',
				'wpr_custom_data' => 'custom',
			)
		);

        add_settings_section(
			'Software_discount',
			'Software Discount',
            'software_discount_fields_callback',
			'wpr_academy'
		);

        add_settings_field(
			'wpr_software_discount',
			'Software Discount',
			'software_field_callback',
			'wpr_academy',
			'Software_discount',
			array(
				'label_for'       => 'wpr_software_discount',
				'class'           => 'wpr_row',
				'wpr_custom_data' => 'custom',
			)
		);

        add_settings_field(
			'wpr_discount_period',
			'Discount Period (Days)',
			'discount_period_field_callback',
			'wpr_academy',
			'Software_discount',
			array(
				'label_for'       => 'wpr_discount_period',
				'class'           => 'wpr_row',
				'wpr_custom_data' => 'custom',
			)
		);

	}
);

add_action(
	'admin_menu',
	function() {

		add_menu_page(
			'API settings',
			'API options',
			'manage_options',
			'WPR_API_Settings',
			'wpr_api_pagehtml',
			'dashicons-admin-settings',
            1
		);
	}
);

function wpr_api_pagehtml() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	// check if the user have submitted the settings
	// WordPress will add the "settings-updated" $_GET parameter to the url
	if ( isset( $_GET['settings-updated'] ) ) {
		// add settings saved message with the class of "updated"
		add_settings_error( 'wpr_messages', 'wpr_message', __( 'Settings Saved', 'wpr' ), 'updated' );
	}

	// show error/update messages
	settings_errors( 'wpr_messages' );
	?>
	<div class="wrap">
		<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
		<form action="options.php" method="post">
			<?php
			// output security fields for the registered setting "wpr_academy"
			settings_fields( 'wpr_academy' );

			// output setting sections and their fields
			// (sections are registered for "wpr_academy", each field is registered to a specific section)
			do_settings_sections( 'wpr_academy' );
			// output save settings button
			submit_button( 'Save Settings' );
			?>
		</form>
	</div>
	<?php

}

function api_field_callback( $args ) {
	// Get the value of the setting we've registered with register_setting()
	$options = get_option( 'wpr_option' );
	?>
	
<input
		value="<?php echo $options[$args['label_for']]; ?>"
		id="<?php echo esc_attr( $args['label_for'] ); ?>"
		data-custom="<?php echo esc_attr( $args['wpr_custom_data'] ); ?>"
		name="wpr_option[<?php echo esc_attr( $args['label_for'] ); ?>]"
		type="text">
	<?php
}

function client_id_field_callback( $args ) {
	// Get the value of the setting we've registered with register_setting()
	$options = get_option( 'wpr_option' );
	?>
	
<input
		value="<?php echo $options[$args['label_for']]; ?>"
		id="<?php echo esc_attr( $args['label_for'] ); ?>"
		data-custom="<?php echo esc_attr( $args['wpr_custom_data'] ); ?>"
		name="wpr_option[<?php echo esc_attr( $args['label_for'] ); ?>]"
		type="text">
	<?php
}

function software_field_callback( $args ) {
	// Get the value of the setting we've registered with register_setting()
	$options = get_option( 'wpr_option' );
	?>
	
<input
		value="<?php echo $options[$args['label_for']]; ?>"
		id="<?php echo esc_attr( $args['label_for'] ); ?>"
		data-custom="<?php echo esc_attr( $args['wpr_custom_data'] ); ?>"
		name="wpr_option[<?php echo esc_attr( $args['label_for'] ); ?>]"
		type="number">
	<?php
}

function discount_period_field_callback( $args ) {
	// Get the value of the setting we've registered with register_setting()
	$options = get_option( 'wpr_option' );
	?>
	
<input
		value="<?php echo $options[$args['label_for']]; ?>"
		id="<?php echo esc_attr( $args['label_for'] ); ?>"
		data-custom="<?php echo esc_attr( $args['wpr_custom_data'] ); ?>"
		name="wpr_option[<?php echo esc_attr( $args['label_for'] ); ?>]"
		type="number">
	<?php
}


