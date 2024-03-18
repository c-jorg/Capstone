<?php
$file = fopen('output.csv', 'r');

echo fread($file, filesize('output.csv'));
fclose($file);
?>