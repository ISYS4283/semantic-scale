<?php namespace jpuck\wordpress\plugins\SemanticScale;

class Leaderboard {
	protected $wpdb;
	protected $words;

	public function __construct() {
		global $wpdb;
		$this->wpdb = $wpdb;

// 		$this->words = SemanticScale::get_instance()->wordsource()->fetch();
	}

	protected function get_blogs() {
		$sql = "SELECT blog_id, path FROM wp_blogs WHERE blog_id <> 1";

		$blogs = $this->wpdb->get_results($sql, 'ARRAY_A');

		foreach ( $blogs as &$blog ) {
			$blog['name'] = trim($blog['path'], '/');
		}

		return $blogs;
	}

	protected function get_scores() {
		foreach ( $this->get_blogs() as $blog ) {
			$sql = "
				SELECT p.post_modified, p.guid, pm.meta_value AS 'score'
				FROM wp_{$blog['blog_id']}_posts p
				LEFT JOIN wp_{$blog['blog_id']}_postmeta pm
				   ON p.ID = pm.post_id
				WHERE p.post_type   = 'post'
				  AND p.post_status = 'publish'
				  AND pm.meta_key   = 'semantic-scale'
				ORDER BY p.post_date
				LIMIT 1;
			";

			$result = $this->wpdb->get_results($sql, 'ARRAY_A');
			if ( !empty($result) ) {
				$array []= array_merge($blog, $result[0]);
			}
		}

		if ( !empty($array) ) {
			// sort by date first for default tie-breaker order
			usort($array, function($a, $b){
				return $a['post_modified'] <=> $b['post_modified'];
			});

			// then actually rank by score (ties should preserve older first)
			usort($array, function($a, $b){
				return $b['score'] <=> $a['score'];
			});
		}

		return $array ?? [];
	}

	public function render() : string {
		$blogs = "
			<table><thead><tr>
				<th>Rank</th>
				<th>Score</th>
				<th>Name</th>
				<th>Post</th>
			</tr></thead><tbody>";

		$rank = 1;
		foreach ( $this->get_scores() as $blog ) {
			$blogs .= "<tr>";
			$blogs .= "<td>".$rank++."</td>";
			$blogs .= "<td>$blog[score]</td>";
			$blogs .= "<td>$blog[name]</td>";
			$blogs .= "<td><a href='$blog[guid]'>$blog[guid]</a></td>";
			$blogs .= "</tr>";
		}

		$blogs .= "</tbody></table>";

		return $blogs;
	}

	public function __toString() {
		return $this->render();
	}
}
