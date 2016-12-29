<?php namespace jpuck\wordpress\plugins\SemanticScale;

class SemanticScale {
	private static $instance;

	public static function get_instance() {
		if ( ! self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	public function __construct() {
		add_filter( 'the_content', array( $this, 'the_content' ) );
	}

	public function the_content($input) {
		return $input . "<p>This is the Semantic Scale plugin.</p>";
	}
}
