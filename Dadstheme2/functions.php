<?php
/**
 * tgaf engine room
 *
 * @package storefront
 */

 //add_action( 'wp_enqueue_scripts', 'tgaf_child_theme_dequeue_style', 999 );

 /**
  * Dequeue the Storefront Parent theme core CSS
  */
 function tgaf_child_theme_dequeue_style() {
     wp_dequeue_style( 'storefront-style' );
     wp_dequeue_style( 'storefront-woocommerce-style' );
 }

 add_action( 'wp_enqueue_scripts', 'tgaf_theme_enqueue_styles', 998 );
 function tgaf_theme_enqueue_styles() {

   wp_enqueue_style( 'normalize', get_stylesheet_directory_uri() . '/assets/normalize.css' );
   if ( is_page_template( 'template-homepage.php' ) && has_post_thumbnail() ) {
     wp_dequeue_script('storefront-homepage');
     wp_enqueue_script( 'storefront-homepage-dads', get_stylesheet_directory_uri() . '/assets/homepage.js', array( 'jquery' ), '20170709', true );
   }

 }

/**
  * Removes the Woocommerce and Wordpress credit
  */
add_action( 'init', 'tgaf_custom_remove_footer_credit', 10 );

function tgaf_custom_remove_footer_credit () {
  remove_action( 'storefront_footer', 'storefront_credit', 20 );
  add_action( 'storefront_footer', 'tgaf_custom_storefront_credit', 20 );
}

function tgaf_custom_storefront_credit() {
	?>
	<div class="site-info">
		&copy; <?php echo get_bloginfo( 'name' ) . ' ' . get_the_date( 'Y' ); ?>
	</div><!-- .site-info -->
	<?php
}


/**
  * Modified header widget area to hide the display when it is in handheld-navigation mode
  */
if ( ! function_exists( 'storefront_header_widget_region' ) ) {
	/**
	 * Display header widget region
	 *
	 * @since  1.0.0
	 */
	function storefront_header_widget_region() {
		if ( is_active_sidebar( 'header-1' ) ) {
		?>
		<div class="header-widget-region" role="complementary">
      <div class="header-widget-tgaf" role="complementary">
        <div class="col-full">
          <?php dynamic_sidebar( 'header-1' ); ?>
        </div>
      </div>
		</div>
		<?php
		}
	}
}

/**
  * Remove the search bar from the header
  */
add_action( 'init', 'tgaf_remove_storefront_header_search' );

function tgaf_remove_storefront_header_search() {
  remove_action( 'storefront_header', 'storefront_product_search', 	40 );
}

/**
 * Alters the output of the homepage product categories on the Storefront theme
 * Affects the storefront_product_categories_args filter in /inc/structure/template-tags.php
 * Thanks to https://gist.github.com/stuartduff/95e7c786b59aafc0d6b5
 */

function tgaf_display_all_home_product_categories( $args ) {

	// Sets the maximum product categories to 50, you can increase this to display more if need be.
	$args['limit'] = 50;

	// Output
	return $args;

}
add_filter( 'storefront_product_categories_args', 'tgaf_display_all_home_product_categories' );
