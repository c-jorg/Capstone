<?php
$file = fopen('output.csv', 'r');

echo fread($file, filesize('output.txt'));
fclose($file);
?>