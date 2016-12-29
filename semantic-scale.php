<?php
/**
 * @package Semantic_Scale
 * @version 0.1.0
 */
/*
Plugin Name: Semantic Scale
Plugin URI: https://github.com/MyTeamName/semantic-scale
Description: Provides a percentage grade for presence of specific words in a post.
Author: Jeff Puckett
Version: 0.1.0
Author URI: http://jeffpuckett.com/
*/

require_once __DIR__.'/vendor/autoload.php';

\jpuck\wordpress\plugins\SemanticScale\SemanticScale::get_instance();
