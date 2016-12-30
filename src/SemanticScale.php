<?php namespace jpuck\wordpress\plugins\SemanticScale;

use jpuck\php\bootstrap\ProgressBar\ProgressBar;

class SemanticScale {
	private static $instance;

	public static function get_instance() {
		return static::$instance ?? static::$instance = new static();
	}

	public function __construct() {
		// TODO: use configuration manager
		$this->wordsource = new WordSourceJsonFile(__DIR__.'/../scratch.json');

		add_action( 'wp_head',     array( ProgressBar::class, 'wp_head' ) );
		add_filter( 'the_content', array( $this, 'the_content' ) );
		add_action( 'save_post',   array( $this, 'save_post' ), 1, 3 );
	}

	public function the_content($input) {
		$grade = (int) get_post_meta( get_the_ID(), 'semantic-scale', true );

		$progressbar = new ProgressBar($grade);

		return $input . "<hr/><p><strong>Semantic Scale:</strong>$progressbar</p>";
	}

	public function save_post(int $post_ID, \WP_Post $post, bool $update) {
		$scaler = new Scaler($post, $this->wordsource);
		update_post_meta( $post_ID, 'semantic-scale', $scaler->grade() );
	}
}
