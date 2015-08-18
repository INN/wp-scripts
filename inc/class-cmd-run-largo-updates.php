<?php

include_once __DIR__ . '/class-cmd.php';

class RunLargoUpdates extends WPScriptCmd {

	function __construct($attributes) {
		parent::__construct(null, $attributes);
	}

	function main() {
		if (!function_exists('largo_version') || version_compare(largo_version(), '0.4.0') == -1)
			throw new Exception('This command must be run on a blog using Largo v0.4+');

		global $wpdb;

		if (!empty($this->blog_id))
			$site_blog_ids = array((object) array('blog_id' => $this->blog_id));
		else
			$site_blog_ids = $wpdb->get_results("SELECT blog_id FROM wp_blogs where blog_id > 1");

		$data = array();
		$ret = '';
		foreach ($site_blog_ids as $b) {
			switch_to_blog($b->blog_id);

			if (function_exists('largo_perform_update')) {
				$result = largo_perform_update();
				if (!empty($result))
					print "Succesfully updated: " . $blog['domain'] . "\n";
				else
					print "Error updating: " . $blog['domain'] . "\n";
			}

			restore_current_blog();
		}

		return $ret;
	}
}
