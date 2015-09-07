<?php

include_once __DIR__ . '/class-cmd.php';

class ListActiveThemesCmd extends WPScriptCmd {

	function __construct($attributes) {
		parent::__construct(null, $attributes);
	}

	function main() {
		global $wpdb;

		if (!empty($this->blog_id))
			$site_blog_ids = array((object) array('blog_id' => $this->blog_id));
		else
			$site_blog_ids = $wpdb->get_results($wpdb->prepare(
				"SELECT blog_id FROM wp_blogs where blog_id > 1"));

		$ret = '';
		foreach ($site_blog_ids as $b) {
			switch_to_blog($b->blog_id);
			$theme = get_option('stylesheet');

			if ($this->type == 'html') {
				$ret .= "<div style='margin:20px 0;'>";
				$ret .= "<h2>" . get_bloginfo('name') . "</h2>";
				$ret .= "<ul>";
			} else
				$ret .= "" . get_bloginfo('name') . ":";

			if ($this->type == 'html') {
				$ret .= "<li>" . $theme . "</li>";
			} else
				$ret .= " " . $theme . "\n";

			if ($this->type == 'html') {
				$ret .= "</ul>";
				$ret .= "</div>";
			} else
				$ret .= "\n";

			restore_current_blog();
		}

		return $ret;
	}
}
