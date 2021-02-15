<?php
class Labels_To_Tags extends Plugin {
   private $host;

	public function about() {
        return array(1.0,
            'Add labels as tags in generated feeds',
            'vnab',
            true);
    }

	public function api_version() {
		return 2;
	}

	public function init( $host ) {
		$this->host = $host;
		$host->add_hook( $host::HOOK_ARTICLE_EXPORT_FEED, $this );
	}

	public function hook_article_export_feed( $line, $feed, $is_cat, $owner_uid ) {

		// get all LABELS for this article / line
   		$labels = Article::_get_labels($line['id'], $owner_uid);

		if (count($labels) > 0) {
			foreach ($labels as $label) {
				array_push($line['tags'], $label[1]); // the name of the label is in [1]
			}

			$line['tags'] = array_unique($line['tags']);
		}

		return $line;
	}
}
