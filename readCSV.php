<?php
$file = fopen('output.txt', 'r');
$info = fread($file, filesize('output.txt'));
//$info = stream_get_contents($file);
fclose($file);
$lines = explode("\n", $info);

$display = "<table class='csvTable'>";
foreach($lines as $line){
    $element = explode(',',$line);
    $display .= "<tr class='csvTable'>";
    foreach($element as $tableData){
        $display .= "<td class='csvTable'>".$tableData."</td>";
    }
    $display .= "</tr>";
}
$display .= "</table>";
echo $display;
//echo fread($file, filesize('output.txt'));

?>