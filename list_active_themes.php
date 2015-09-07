<?php

include_once __DIR__ . '/inc/class-cmd-list-active-themes.php';

$cmd = new ListActiveThemesCmd($_GET);
$cmd->execute();
