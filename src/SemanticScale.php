<?php namespace jpuck\wordpress\plugins\SemanticScale;

class SemanticScale {
	private static $instance;

	public static function get_instance() {
		return static::$instance ?? static::$instance = new static();
	}

	public function __construct() {
		add_filter( 'the_content', array( $this, 'the_content' ) );
		add_action( 'save_post',   array( $this, 'save_post' ), 1, 3 );
	}

	public function the_content($input) {
		$content = get_post_meta( get_the_ID(), 'semantic-scale-mod', true );
		return $input . "<p>Semantic Scale last modified: $content</p>";
	}

	public function save_post(int $post_ID, \WP_Post $post, bool $update) {
		update_post_meta( $post_ID, 'semantic-scale-mod', gmdate("Y-m-d H:i:s") );
	}
}
