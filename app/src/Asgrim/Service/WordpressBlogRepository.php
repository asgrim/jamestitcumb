<?php

namespace {
	// This replaces WP's translator
	function _x($foo, $bar)
	{
		return $foo;
	}

	// This replaces WP's apply filters method
	function apply_filters($foo, $bar)
	{
		return $bar;
	}
}

namespace Asgrim\Service
{
	require 'vendor/wp_formatting.php';

	class WordpressBlogRepository implements BlogRepositoryInterface
	{
		/**
		 * @var \PDO
		 */
		protected $pdoConnection;

		public function __construct(\PDO $pdoConnection)
		{
			$this->pdoConnection = $pdoConnection;
		}

		public function fetchBySlug($slug)
		{
			return false;
		}

		protected function renderRowAsPost($row)
		{
			$content = '<h1>' . $row['title'] . '</h1>';
			$content .= mb_convert_encoding(shortcode_unautop(wpautop(convert_chars(wptexturize($row['content'])))), "UTF-8", "iso-8859-1");
			return $content;
		}

		public function fetchLast($howeverMany)
		{
			$howeverMany = (int)$howeverMany;

			if ($howeverMany <= 0 || $howeverMany > 20)
			{
				$howeverMany = 5;
			}

			$sql = "
				SELECT
					DISTINCT wp_posts.ID AS post_id,
					wp_posts.post_date AS post_date,
					wp_posts.post_content AS content,
					wp_posts.post_title AS title,
					wp_posts.post_name AS link
				FROM
					wp_term_relationships
					JOIN wp_posts ON (wp_term_relationships.object_id = wp_posts.ID)
				WHERE
					wp_term_relationships.term_taxonomy_id IN (4, 107)
					AND wp_posts.post_status = 'publish'
				ORDER BY post_date DESC
				LIMIT :howeverMany
			";

			$statement = $this->pdoConnection->prepare($sql);
			$statement->bindParam('howeverMany', $howeverMany, \PDO::PARAM_INT);
			$statement->execute();

			$content = '';

			while ($row = $statement->fetch())
			{
				$content .= $this->renderRowAsPost($row);
			}

			return $content;
		}
	}
}
