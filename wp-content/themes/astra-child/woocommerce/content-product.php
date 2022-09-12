<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;


// Ensure visibility.
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}
?>
<li <?php wc_product_class( '', $product ); ?>>
	<?php
	/**
	 * Hook: woocommerce_before_shop_loop_item.
	 *
	 * @hooked woocommerce_template_loop_product_link_open - 10
	 */
	do_action( 'woocommerce_before_shop_loop_item' );

	/**
	 * Hook: woocommerce_before_shop_loop_item_title.
	 *
	 * @hooked woocommerce_show_product_loop_sale_flash - 10
	 * @hooked woocommerce_template_loop_product_thumbnail - 10
	 */
	do_action( 'woocommerce_before_shop_loop_item_title' );
    echo '<button type="button" data-id="' . $product->get_id() . '">Quick view</button>';


	/**
	 * Hook: woocommerce_shop_loop_item_title.
	 *
	 * @hooked woocommerce_template_loop_product_title - 10
	 */
	do_action( 'woocommerce_shop_loop_item_title' );

	/**
	 * Hook: woocommerce_after_shop_loop_item_title.
	 *
	 * @hooked woocommerce_template_loop_rating - 5
	 * @hooked woocommerce_template_loop_price - 10
	 */
	do_action( 'woocommerce_after_shop_loop_item_title' );

	/**
	 * Hook: woocommerce_after_shop_loop_item.
	 *
	 * @hooked woocommerce_template_loop_product_link_close - 5
	 * @hooked woocommerce_template_loop_add_to_cart - 10
	 */
	do_action( 'woocommerce_after_shop_loop_item' );
	?>
</li>



<!-- The Modal -->
<div  class="modal" data-modal_id="<?php echo $product->get_id(); ?>">

<div class="modal-content">
    <span class="close">&times;</span>
	<h1><?php echo $product->get_name(); ?></h1>
		<div class="card">
						<div class="card-img">
							<?php echo $product->get_image(); ?>
						</div>
						<div class="card-txt">
							<div class="card-header">
								<div class="card-header-left">
								<?php echo 'Pret: ' . $product->get_price_html(); ?>
								</div>
							</div>
							<div class="card-title">
								<?php echo $product->get_short_description(); ?>
							</div>
							<hr>
							<div class="card-content">
							<?php
									if( $product->is_type( 'variable' )) {
										woocommerce_variable_add_to_cart(); //simple :)
									} else {
									echo sprintf( '<a rel="nofollow" href="%s" data-quantity="%s" data-product_id="%s" class="%s">%s</a>',
										esc_url( $product->add_to_cart_url() ),
										esc_attr( isset( $quantity ) ? $quantity : 1 ),
										esc_attr( $product->get_id() ), // get_id() instead of id
										esc_attr( isset( $class ) ? $class : 'button' ),
										esc_html( $product->add_to_cart_text() )
									);
									}
								?>
							</div>
							<div class="card-footer">
								<div class="card-footer-right">
								<?php if ( wc_product_sku_enabled() && ( $product->get_sku() || $product->is_type( 'variable' ) ) ) : ?>
									<span class="sku_wrapper"><?php esc_html_e( 'SKU:', 'woocommerce' ); ?> 
										<span class="sku">
											<?php echo ( $sku = $product->get_sku() ) ? $sku : esc_html__( 'N/A', 'woocommerce' ); ?>
										</span>
									</span>
								<?php endif; ?>
								<hr>
								<?php echo 'Category: ' . $product->get_categories(); ?>
								</div>
							</div>
							</div>
						</div>
		</div>
</div>

