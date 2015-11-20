<?php 
/*
Plugin Name: WooNrlb Styleable dropdowns
Description: Works only with woocommerce
Author: BrkoDeluxe
Version: 1.0
Author URI: http://www.neuralab.net
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} 

if ( in_array('woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
	function addDeps() { 
		wp_enqueue_script( 'SelectTransform', plugin_dir_url( __FILE__ ) . '/js/jquery.dd.min.js', array(), true ); 
		wp_enqueue_style( 'SelectTransformCSS', plugin_dir_url(__FILE__ ) . '/js/dd.css' ); 
	} 
	
	add_action( 'wp_enqueue_scripts', 'addDeps',99); 
	
	function print_style_inline() {?>
		<style>
			.variations select {
				opacity: 0;
				visibility: hidden;
				position: absolute;
			}
		</style><?php 
	} 
	
	function print_plugin_inline() { // too small to bother making a new file - transform native wc select to something styleabe ?>
		<script>
			$(document).ready(function() {
				var oDropdown = $(".variations select<?php echo apply_filters('dds_not_css_selector', ''); ?>").msDropdown({enableAutoFilter: false}).data('dd');
				$('.variations .dd').click(function() {
					var selectId = $(this).attr('id').slice(0, -5);
					$('#' + selectId).trigger('touchstart');
				});
			});
		</script><?php 
	} 
	
	add_action( 'wp_footer', 'print_plugin_inline',99 ); add_action( 'wp_head', 'print_style_inline',99 ); 
}