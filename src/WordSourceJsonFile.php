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

	public function fetch($date) : Array {
		// TODO: search JSON for week
		$date = new Carbon($date);

		return $words ?? [
			['entity relationship diagram', 'erd', 'e.r.d.'],
			['create, read, update, delete', 'create read update delete', 'crud', 'c.r.u.d.'],
			['something else', 'nada'],
		];
	}
}
