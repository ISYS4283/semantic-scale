<?php require_once __DIR__.'/../vendor/autoload.php';

use jpuck\wordpress\plugins\SemanticScale\{WordSourceJsonFile,Scaler};

class WP_Post {}

$post = new WP_Post;
$post->post_content = file_get_contents(__DIR__.'/scratch.txt');
$post->post_date = '2017-01-19';

$wordsource = new WordSourceJsonFile(__DIR__.'/words.json');

$scaler = new Scaler($post, $wordsource, ['echo-missed'=>true]);

echo PHP_EOL;
var_dump($scaler);
