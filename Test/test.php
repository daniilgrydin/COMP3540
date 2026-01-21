<?php
$CODE = 0;
$NONE = 1;

$lines = file('test.md');
$mode = $NONE;
$output = "";
foreach ($lines as $line_num => $line) {
    if ($mode == $NONE) {
        if (str_starts_with($line, "###")) {
            $output .= "<h3>" . substr($line, 3) . "</h3>";
        } elseif (str_starts_with($line, "##")) {
            $output .= "<h2>" . substr($line, 2) . "</h2>";
        } elseif (str_starts_with($line, "#")) {
            $output .= "<h1>" . substr($line, 1) . "</h1>";
        } elseif (str_starts_with($line, "```")) {
            $mode = $CODE;
        } elseif (strlen($line) > 0) {
            $output .= "<p>$line</p>";
        }
    } elseif ($mode == $CODE) {
        if (str_starts_with($line, "```")) {
            $mode = $NONE;
        } else {
            $text = str_replace("&", "&amp;", $line);
            $text = str_replace("<", "&lt;", $text);
            $text = str_replace(">", "&gt;", $text);
            $output .= "$text\n";
        }
    }
}
echo $output;
?>