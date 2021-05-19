<?php
/**
 * Plugin Name:       Debug block
 * Description:       Debug block for a single block server side rendered block
 * Requires at least: 5.7
 * Requires PHP:      7.3
 * Version:           0.0.0
 * Author:            bobbingwide
 * License:           GPLv3
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       sb-debug-block
 *
 * @package           sb-debug-block
 */

/**
 * Registers the block using the metadata loaded from the `block.json` file.
 * Behind the scenes, it registers also all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://developer.wordpress.org/block-editor/tutorials/block-tutorial/writing-your-first-block-type/
 */
function oik_sb_sb_debug_block_block_init() {
	$args = [ 'render_callback' => 'oik_sb_sb_debug_block_dynamic_block'];
	register_block_type_from_metadata( __DIR__, $args );
}

function oik_sb_sb_debug_block_loaded() {
	add_action( 'init', 'oik_sb_sb_debug_block_block_init' );
	add_action( 'rendering_template_part', 'oik_sb_sb_debug_block_rendering_template_part', 10, 2);
	add_action( 'rendering_template', 'oik_sb_sb_debug_block_rendering_template', 10, 3 );
}
/**
 * Implements oik-sb/sb-debug-block block.
 *
 *
 * @param $attributes
 * @param $content
 * @param $block
 *
 * @return string
 */
function oik_sb_sb_debug_block_dynamic_block( $attributes, $content, $block ) {
	require_once __DIR__ . '/libs/class-oik-sb-sb-debug-block.php';
	$sb_debug_block = new Oik_sb_sb_debug_block();
	$html = $sb_debug_block->render( $attributes, $content, $block );
	return $html;
}

/**
 * Implements `rendering_template_part` action.
 *
 * If the class isn't loaded then load it
 * When it's loaded get the instance
 * Pass the action hook args to the rendering_template_part method.
 *
 * @param $attributes
 * @param $seen_ids
 */
function oik_sb_sb_debug_block_rendering_template_part( $attributes, $seen_ids ) {
	if ( !class_exists( 'Oik_sb_sb_debug_block_template_part' ) ) {
		require_once __DIR__ . '/libs/class-oik-sb-sb-debug-block-template-part.php';
	}
	if ( class_exists( 'Oik_sb_sb_debug_block_template_part') ) {
		$oik_sb_sdbtp = Oik_sb_sb_debug_block_template_part::get_instance();
		$oik_sb_sdbtp->rendering_template_part( $attributes, $seen_ids );
	}
}

/**
 * Implements `rendering_template` action.
 *
 * If the class isn't loaded then load it
 * When it's loaded get the instance
 * Pass the action hook args to the rendering_template method.
 *
 * @param $attributes
 * @param $seen_ids
 */
function oik_sb_sb_debug_block_rendering_template( $current_template, $type, $templates ) {
	if ( !class_exists( 'Oik_sb_sb_debug_block_template' ) ) {
		require_once __DIR__ . '/libs/class-oik-sb-sb-debug-block-template.php';
	}
	if ( class_exists( 'Oik_sb_sb_debug_block_template') ) {
		$oik_sb_sdbt = Oik_sb_sb_debug_block_template::get_instance();
		$oik_sb_sdbt->rendering_template( $current_template, $type, $templates );
	}
}


oik_sb_sb_debug_block_loaded();
