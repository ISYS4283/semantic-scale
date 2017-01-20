<?php namespace jpuck\wordpress\plugins\SemanticScale;

use jpuck\php\bootstrap\ProgressBar\ProgressBar;

class SemanticScale {
	private static $instance;
	protected $wordsource;

	public static function get_instance() {
		return static::$instance ?? static::$instance = new static();
	}

	public function __construct() {
		// TODO: use configuration manager
		$this->wordsource( new WordSourceJsonFile(__DIR__.'/../words.json') );

		add_action( 'wp_head',     array( ProgressBar::class, 'wp_head' ) );
		add_filter( 'the_content', array( $this, 'the_content' ) );
		add_action( 'save_post',   array( $this, 'save_post' ), 1, 3 );
	}

	public function the_content($input) {
		if ( get_post_type() === 'post' ) {
			$grade = (int) get_post_meta( get_the_ID(), 'semantic-scale', true );

			$progressbar = new ProgressBar($grade);

			$input .= "<hr/><p><strong>Semantic Scale:</strong>$progressbar</p>";
		}

		return $input;
	}

	public function wordsource(WordSource $wordsource = null) {
		if ( isset($wordsource) ) {
			$this->wordsource = $wordsource;
		}

		return $this->wordsource;
	}

	public function save_post(int $post_ID, \WP_Post $post, bool $update) {
		$scaler = new Scaler($post, $this->wordsource());
		update_post_meta( $post_ID, 'semantic-scale', $scaler->grade() );
	}
}
