<?php

include_once __DIR__ . '/class-cmd.php';

class LargoVersionStatus extends WPScriptCmd {

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
			$stored_largo_version = of_get_option('largo_version');
			$ret .= get_bloginfo('name') . "\n";
			$ret .= "    Largo version: " . $stored_largo_version . "\n";
			$ret .= "\n";
			restore_current_blog();
		}

		return $ret;
	}
}
