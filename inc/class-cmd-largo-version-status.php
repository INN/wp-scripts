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
			$site_blog_ids = $wpdb->get_results("SELECT blog_id FROM wp_blogs where blog_id > 1");

		$data = array();
		$ret = '';
		foreach ($site_blog_ids as $b) {
			switch_to_blog($b->blog_id);
			$stored_largo_version = of_get_option('largo_version');
			if (!empty($stored_largo_version))
				$data[$stored_largo_version][] = get_bloginfo('name');
			else
				$data['No version specified'][] = get_bloginfo('name');

			restore_current_blog();
		}

		uksort($data, function($a, $b) {
			if ($a == 'No version specified')
				return -1;
			if ($b == 'No version specified')
				return 1;
			return version_compare($a, $b);
		});

		foreach ($data as $label => $sites) {
			$ret .= 'Largo version: ' . $label . "\n";
			foreach ($sites as $site)
				$ret .= "    " . $site . "\n";
			$ret .= "\n";
		}

		return $ret;
	}
}
