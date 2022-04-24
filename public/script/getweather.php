<?php
$output = shell_exec(__DIR__ . '/weather.sh');
echo $output;
