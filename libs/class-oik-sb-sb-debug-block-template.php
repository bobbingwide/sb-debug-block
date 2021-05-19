<?php

/**
 * Class Oik_sb_sb_debug_block_template
 * @package sb-debug-block
 * @copyright (C) Copyright Bobbing Wide 2021
 *
 * Enables debugging of the template.
 */

class Oik_sb_sb_debug_block_template {

	private static $instance = null;

	private $current_template;
	private $type;
	private $templates;


	public function __construct() {
		$this->current_template = null;
		$this->type = null;
		$this->templates = null;
	}

	/**
	 * Utility method to retrieve the main instance of the class.
	 *
	 * The instance will be created if it does not exist yet.

	 * @return  The main instance.
	 */
	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	public function rendering_template( $current_template, $type, $templates ) {
		$this->current_template = $current_template;
		$this->type = $type;
		$this->templates = $templates;
	}


	/**
	 * Attempts to return the template name.
	 *
	 * This seemed almost impossible with the current implementation
	 * as name of the file or ID of the post that's chosen is not exposed.
	 * Under the covers Gutenberg decides which template to load and does this
	 * setting the global $_wp_current_template_content, but nothing else.
	 * I added a do_action call for `rendering_template` to allow routines
	 * to hook into the logic and obtain the required information.
	 *
	 * `
	[type] => (string) "wp_template"
	[theme] => (string) "sb"
	[slug] => (string) "singular"
	[id] => (string) "sb//singular"
	[title] => (string) "Singular"
	[content] => (string) "<!-- wp:html -->
	 * `
	 */
	public function get_template_name() {
		$template_name = null; 'YGIAGAM';
		bw_trace2(  $this->current_template, "current_template", false );
		if ( $this->current_template ) {

			$template_name = $this->current_template->slug;
			if ( $this->current_template->wp_id) {
				$template_name.=$this->current_template->wp_id;
			} else {
				$template_name .= '.html';
			}
			$template_name .= " - ";
			$template_name .= $this->current_template->title;
		}
		return $template_name;
	}

	public function get_template() {
		return $this->template;
	}

	public function get_type() {
		return $this->type;
	}
	public function get_templates() {
		return $this->templates;
	}

}
