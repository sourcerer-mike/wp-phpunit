<?php

namespace WP_PHPUnit;

use WP_PHPUnit\WordPress\Abstract_Part;
use WP_PHPUnit\WordPress\Action;
use WP_PHPUnit\WordPress\Core;
use WP_PHPUnit\WordPress\Filter;

class WordPress {

	protected $_core;
	protected $_filter;
	protected $_parts;

	public function __construct() {
		$this->_core = new Core();
	}

	/**
	 * @return \WP_PHPUnit\WordPress\Action
	 */
	public function action( $identifier ) {
		$name = 'action::' . $identifier;
		if ( ! isset( $this->_parts[ $name ] ) || ! $this->_parts[ $name ] ) {
			$this->_parts[ $name ] = new Action( $identifier );
		}

		return $this->_parts[ $name ];
	}

	/**
	 * @return Filter
	 */
	public function filter( $identifier ) {
		$name = 'filter::' . $identifier;
		if ( ! isset( $this->_parts[ $name ] ) || ! $this->_parts[ $name ] ) {
			$this->_parts[ $name ] = new Filter( $identifier );
		}

		return $this->_parts[ $name ];
	}

	public function reset() {
		$this->core()->reset();

		foreach ( $this->_parts as $tag => $part ) {
			/** @var Abstract_Part $part */
			$part->reset();

			unset( $this->_parts[ $tag ] );
		}
	}

	/**
	 * @return Core
	 */
	public function core() {
		return $this->_core;
	}
}