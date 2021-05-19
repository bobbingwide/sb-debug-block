<?php

/**
 * Class Oik_sb_sb_debug_block_template_part
 * @package sb-debug-block
 * @copyright (C) Copyright Bobbing Wide 2021
 *
 * Enables debugging of template parts as they're being processed.
 */

class Oik_sb_sb_debug_block_template_part {

	private static $instance = null;

	private $attributes;
	private $seen_ids;

	public function __construct() {
		$this->attrubutes = null;
		$this->seen_ids = [];
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

	public function rendering_template_part( $attributes, $seen_ids ) {
		$this->attributes = $attributes;
		$this->seen_ids = $seen_ids;
	}

	public function get_template_part_name() {
		$template_part_name = null;
		if ( $this->attributes ) {
			$template_part_name = $this->attributes['slug'];

		} else {
			$end = end( $this->seen_ids );
			if ( $end ) {
				$template_part_name=key( $this->seen_ids );
			}
		}
		return $template_part_name;
	}

	public function get_attributes() {
		return $this->attributes;
	}
	public function get_seen_ids() {
		return $this->seen_ids;
	}

}
