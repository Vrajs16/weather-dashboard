<?php
ignore_user_abort(true)
$output = shell_exec(__DIR__ . '/weather.sh');
echo $output;
