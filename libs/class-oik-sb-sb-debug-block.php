<?php

/**
 * Class Oik_sb_sb_debug_block
 * @package sb-debug-block
 * @copyright (C) Copyright Bobbing Wide 2021
 *
 * Enables the oik-sb/sb-debug-block
 */

class Oik_sb_sb_debug_block {

	private $attributes;
	private $content;
	private $block;

	private static $rendered_template_name = false;

	function __construct() {
		// No need to do anything. See render()
		//self::$rendered_template_name = false;
	}

	/**
	 * Renders the oik-sb/sb-debug-block.
	 *
	 * @param $attributes
	 * @param $content
	 * @param $block
	 *
	 * @return string
	 */
	function render( $attributes, $content, $block ) {
		$this->attributes = $attributes;
		$this->content = $content;
		$this->block = $block;
		$classes='';
		if ( isset( $attributes['textAlign'] ) ) {
			$classes.='has-text-align-' . $attributes['textAlign'];
		}

		// This returns class="wp-block-oik-sb-sb-debug-block"
		// so we probably don't need WP_DEBUG
		// but could do with other classes such as 'template'/ 'template-part' / 'contents'
		$wrapper_attributes=get_block_wrapper_attributes( array( 'class'=>$classes ) );

		// @TODO change default to false when toggle is added to the block.
		$showContents  =isset( $attributes['showContents'] ) ? $attributes['showContents'] : true;
		//$content=__( 'Debug block.', 'sb-debug-block' );
		if ( $showContents ) {
			$this->content .= $this->get_escaped_contents();
		}

		/**
		 * How do we decide which bits to render?
		 * Is it OK to apparently render the block multiple times?
		 */

		$html = $this->render_template_name();
		$html .= $this->render_template_part_name();

		$html .=sprintf( '<div %1$s>%2$s</div>', $wrapper_attributes, $this->content );
		return $html;

	}

	/**
	 * Returns the escaped post_content for the post.
	 *
	 * @return string|null
	 */
	function get_escaped_contents() {
		bw_trace2( $this, "this");
		$contents = null;
		$post_id = $this->get_post_id();
		if ( $post_id ) {
			$post = get_post( $post_id );
			if ( $post ) {
				$contents= $this->escape_contents( $post->post_content );
			}
		}
		return $contents;
	}

	/**
	 * Returns the post_id for the chosen post
	 *
	 * id attribute is for additional debugging.
	 */
	function get_post_id() {
		$post_id = bw_array_get( $this->attributes, "id", null );
		if ( !$post_id ) {
			$post_id = get_the_ID();
		}
		return $post_id;
	}

	function escape_contents( $contents ) {
		$contents=str_replace( "\r", "\\r", $contents );
		$contents=str_replace( "\n", "\\n", $contents );
		$contents=str_replace( "\t", "\\t", $contents );
		$escaped_contents =  esc_html( $contents );
		return $escaped_contents;
	}


	function wrap_debug( $template_name, $class='WP_DEBUG' ) {
		$wrapper_attributes = get_block_wrapper_attributes( array( 'class'=> $class ) );
		$html=sprintf( '<div %1$s>%2$s</div>', $wrapper_attributes, $template_name );
		return $html;

	}

	function is_debug() {
		// WP_DEBUG_DISPLAY must only be honored when WP_DEBUG. This precedent
		// is set in `wp_debug_mode()`.
		$is_debug = defined( 'WP_DEBUG' ) && WP_DEBUG &&
		            defined( 'WP_DEBUG_DISPLAY' ) && WP_DEBUG_DISPLAY;
		return $is_debug;
	}

	/**
	 * This will return null if a template part has not been rendered
	 * OR the 'rendering_template_part' action has not been run.
	 *
	 * @return int|mixed|string|null
	 */
	function get_template_part_name() {
		bw_trace2( $this, "this");
		if ( !class_exists( 'Oik_sb_sb_debug_block_template_part' ) ) {
			require_once __DIR__ . '/class-oik-sb-sb-debug-block-template-part.php';
		}
		$oik_sb_sdbtp = Oik_sb_sb_debug_block_template_part::get_instance();
		$template_part_name = $oik_sb_sdbtp->get_template_part_name();

		return $template_part_name;
	}

	/**
	 * We only need to do this once.
	 */
	function render_template_name() {
		$html = null;
		if ( false === self::$rendered_template_name ) {

			$template_name=$this->get_template_name();
			$html =$this->wrap_debug( $template_name, 'template' );
		}
		self::$rendered_template_name = true;
		return $html;
	}

	/**
	 * Template parts may be nested.
	 *
	 * Can we debug entry and exit?
	 * @return string
	 */
	function render_template_part_name() {
		$html = null;
		$template_part_name=$this->get_template_part_name();
		$html =$this->wrap_debug( $template_part_name, 'template-part' );
		return $html;
	}

	/**
	 * Returns the template name.
	 *
	 * It indicates which template has been loaded and from where.
	 *
	 * This will return null if a template is not being rendered
	 * OR the 'rendering_template' action has not been run.
	 *
	 * @return int|mixed|string|null
	 */
	function get_template_name() {
		bw_trace2( $this, "this");
		if ( !class_exists( 'Oik_sb_sb_debug_block_template' ) ) {
			require_once __DIR__ . '/class-oik-sb-sb-debug-block-template.php';
		}
		$oik_sb_sdbt = Oik_sb_sb_debug_block_template::get_instance();
		$template = $oik_sb_sdbt->get_template_name();

		return $template;
	}

}
