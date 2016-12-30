<?php namespace jpuck\wordpress\plugins\SemanticScale;

interface WordSource {
	public function fetch($id) : Array;
}
