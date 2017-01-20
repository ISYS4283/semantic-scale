<?php namespace jpuck\wordpress\plugins\SemanticScale;

interface WordSource {
	public function fetch(\WP_Post $post = null) : Array;
}
