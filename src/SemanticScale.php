<?php namespace jpuck\wordpress\plugins\SemanticScale;

use jpuck\php\bootstrap\ProgressBar\ProgressBar;
use WP_REST_Server;

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

		add_action( 'rest_api_init', array ( $this, 'register_routes' ) );

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
		if ( get_post_type() === 'post' ) {
			$scaler = new Scaler($post, $this->wordsource());
			update_post_meta( $post_ID, 'semantic-scale', $scaler->grade() );
		}
	}

	/**
	* This function is where we register our routes for our endpoints.
	*/
	public function register_routes() {
		// register_rest_route() handles more arguments but we are going to stick to the basics for now.
		register_rest_route( 'semantic-scale/v1', '/leaderboard', array(
			// By using this constant we ensure that when the WP_REST_Server changes our readable endpoints will work as intended.
			'methods'  => WP_REST_Server::READABLE,
			// Here we register our callback. The callback is fired when this endpoint is matched by the WP_REST_Server class.
			'callback' => [Leaderboard::class, 'get_scores_rest_ensure_response'],
		) );
	}
}
