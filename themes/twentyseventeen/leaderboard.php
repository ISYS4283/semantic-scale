<?php
 /*
  Template Name: Semantic Scale Leaderboard
 */
 /**
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

use jpuck\wordpress\plugins\SemanticScale\Leaderboard;

get_header();
the_post();
?>

<div class="wrap">
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
			<?php twentyseventeen_edit_link( get_the_ID() ); ?>

			<style>
				#comments {
					float: none !important;
					width: 100% !important;
				}
			</style>
			<?php

			echo new Leaderboard;

			the_content();

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;
			?>

		</main>
	</div>
</div>

<?php get_footer();
