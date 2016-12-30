<?php namespace jpuck\wordpress\plugins\SemanticScale;

class SemanticScale {
	private static $instance;

	public static function get_instance() {
		return static::$instance ?? static::$instance = new static();
	}

	public function __construct() {
		// TODO: use configuration manager
		$this->wordsource = new WordSourceJsonFile(__DIR__.'/../scratch.json');

		add_filter( 'the_content', array( $this, 'the_content' ) );
		add_action( 'save_post',   array( $this, 'save_post' ), 1, 3 );
	}

	public function the_content($input) {
		$grade = get_post_meta( get_the_ID(), 'semantic-scale', true );
		// TODO: handle if empty
		// TODO: add output class
		return $input . "<p>Semantic Scale: $grade</p>";
	}

	public function save_post(int $post_ID, \WP_Post $post, bool $update) {
		$scaler = new Scaler($post, $this->wordsource);
		update_post_meta( $post_ID, 'semantic-scale', $scaler->grade() );
	}
}
