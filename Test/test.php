<?php
$CODE = 0;
$NONE = 1;

$lines = file('test.md');
$mode = $NONE;
$output = "
<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content=\"width=device-width, initial-scale=1.0\">
    <title>Daniil Grydin</title>
    <link rel=\"stylesheet\" href=\"https://cs.tru.ca/~T00712793/style.css\">
    <link href=\"https://cs.tru.ca/~T00712793/prism.css\" rel=\"stylesheet\" />
</head>
<body>
";
foreach ($lines as $line_num => $line) {
    if ($mode == $NONE) {
        if (str_starts_with($line, "###")) {
            $output .= "<h3>" . substr($line, 3) . "</h3>";
        } elseif (str_starts_with($line, "##")) {
            $output .= "<h2>" . substr($line, 2) . "</h2>";
        } elseif (str_starts_with($line, "#")) {
            $output .= "<h1>" . substr($line, 1) . "</h1>";
        } elseif (str_starts_with($line, "```")) {
            $language = substr($line, 3);
            $mode = $CODE;
            $output .= "<pre><code class=\"language-$language\">";
        } elseif (strlen($line) > 0) {
            $output .= "<p>$line</p>";
        }
    } elseif ($mode == $CODE) {
        $block_index = bin2hex(random_bytes(4));
        $code = "";
        if (str_starts_with($line, "```")) {
            $mode = $NONE;
            $output .= "</code></pre>";
            $code = str_replace("\"", "'", $code);
            $output .= "<button class=\"run-button\" onclick=\"document.getElementById('$block_index').innerHTML = `$code`\">Run!</button>";
            $output .= "<div id=\"$block_index\" class=\"example\" style=\"width=100%;padding:10px;\">Run result will be here...</div>";
            $output .= `<pre><code>$code</code></pre>`;
        } else {
            $text = str_replace("&", "&amp;", $line);
            $text = str_replace("<", "&lt;", $text);
            $text = str_replace(">", "&gt;", $text);
            $output .= "$text<br>";
            $code .= "$text";
        }
    }
}
echo "$output<script src=\"https://cs.tru.ca/~T00712793/prism.js\"></script></body>";
?>