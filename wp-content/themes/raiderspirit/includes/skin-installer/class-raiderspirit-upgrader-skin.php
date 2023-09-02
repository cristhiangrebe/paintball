<?php

if ( ! class_exists( 'RaiderSpirit_Upgrader_Skin' ) ) {

	class RaiderSpirit_Upgrader_Skin extends WP_Upgrader_Skin {

		/**
		 * Class constructor.
		 *
		 * @since 1.1.0
		 * @param array $args
		 */
		public function __construct( $args = array() ) {
			parent::__construct( $args );
		}

		/**
		 * Output markup after installation processed.
		 */
		public function after() {}

		/**
		 *  Output header markup.
		 */
		public function header() {}

		/**
		 *  Output footer markup.
		 */
		public function footer() {}

		/**
		 *
		 * @since 1.1.0
		 * @param string $string
		 */
		public function feedback($string, ...$args) {}
	}
}
