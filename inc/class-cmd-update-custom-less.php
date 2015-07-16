<?php

include_once __DIR__ . '/class-cmd.php';
include_once ABSPATH . 'wp-content/themes/largo-dev/functions.php';
include_once ABSPATH . 'wp-content/themes/largo-dev/inc/update.php';

class UpdateCustomLess extends WPScriptCmd {

	function __construct($attributes) {
		parent::__construct(null, $attributes);
	}

	function main() {
		global $wpdb;

		if (!empty($this->blog_id))
			$site_blog_ids = array((object) array('blog_id' => $this->blog_id));
		else
			$site_blog_ids = $wpdb->get_results("SELECT blog_id FROM wp_blogs where blog_id > 1");

		$ret = "Recompiling custom LESS for:\n";
		foreach ($site_blog_ids as $b) {
			switch_to_blog($b->blog_id);
			if (Largo::is_less_enabled()) {
				$ret .= "    " . get_bloginfo('name') . " (" . get_bloginfo('url') . ")\n";
				largo_update_custom_less_variables();
			}
			restore_current_blog();
		}

		return $ret;
	}
}
