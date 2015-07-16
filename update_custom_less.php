<?php

include_once __DIR__ . '/inc/class-cmd-update-custom-less.php';

$cmd = new UpdateCustomLess($_GET);
$cmd->execute();
