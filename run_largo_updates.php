<?php

include_once __DIR__ . '/inc/class-cmd-run-largo-updates.php';

$cmd = new RunLargoUpdates($_GET);
$cmd->execute();
