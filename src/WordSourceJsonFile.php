<?php namespace jpuck\wordpress\plugins\SemanticScale;

use Carbon\Carbon;
use InvalidArgumentException;

class WordSourceJsonFile implements WordSource {
	protected $json;

	public function __construct(string $jsonfile) {
		if ( ! is_readable($jsonfile) ) {
			throw new InvalidArgumentException("$jsonfile is not readable.");
		}

		$json = file_get_contents($jsonfile);
		$this->json = json_decode($json, true);
		if ( ! is_array($this->json) ) {
			throw new InvalidArgumentException(
				"Bad JSON: " . json_last_error_msg()
			);
		}
	}

	public function fetch(\WP_Post $post) : Array {
		$date = new Carbon($post->post_date);

		foreach ($this->json as $period) {
			$start  = Carbon::createFromFormat('Y-m-d', $period['start'],  'America/Chicago');
			$finish = Carbon::createFromFormat('Y-m-d', $period['finish'], 'America/Chicago');

			if ( $date->between($start, $finish) ) {
				$words = $period['words'];
				break;
			}
		}

		return $words ?? [];
	}
}
