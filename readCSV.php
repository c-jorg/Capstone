<?php
$file = fopen('output.txt', 'r');

echo fread($file, filesize('output.txt'));
fclose($file);
?>