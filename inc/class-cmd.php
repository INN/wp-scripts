<?php

require_once __DIR__ . '/acl-init.php';
require_once dirname(dirname(__DIR__)) . '/wp-blog-header.php';

class WPScriptCmd {

	function __construct($action, $attributes) {
		$this->action = $action;

		foreach ($attributes as $key => $value)
			$this->{$key} = $value;

		if (!is_user_logged_in()) {
			header('HTTP/1.0 403 Forbidden', true, 403);
			print "Forbidden.";
			die();
		}
	}

	function execute() {
		try {
			$ret = $this->main();
		} catch (Exception $e) {
			header('HTTP/1.1 500 Internal Server Error', true, 500);
			print $e->getMessage();
			die();
		}

		header('HTTP/1.1 200 OK', true, 200);
		print $ret;
		die();
	}

	/**
	 * Override this method in your command class.
	 *
	 * If your command is meant to send data back over the wire, this
	 * should return a string.
	 */
	function main() {
		throw new NotImplementedException();
	}

}
