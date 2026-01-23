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
$snippet_code = "";
$executable_code = "";
$write_executable = false;
$functions_to_do = [];
$show_parts = "";
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
            $show_parts = "";
        } elseif (str_starts_with($line, "---")) {
            $output .= "<hr>";
        } elseif (strlen($line) > 1) {
            $output .= "<p>$line</p>";
        }
    } elseif ($mode == $CODE) {
        $block_index = bin2hex(random_bytes(4));
        if (str_starts_with($line, "```")) {
            $mode = $NONE;
            $output .= "</code></pre>";
            // $output .= "<p>The total code is ".strlen($snippet_code)." characters long.</p>";
            $showparts = str_replace("\"", "'", $showparts);
            $showparts = str_replace("\n", " ", $showparts);
            $function_calls = "";
            foreach($functions_to_do as $_ => $function_name){
                $function_calls = $function_calls . "$function_name();";
            }
            $output .= "<button class=\"run-button\" onclick=\"document.getElementById('$block_index').innerHTML = `$showparts`;$function_calls\">Run!</button>";
            $output .= "<div id=\"$block_index\" class=\"example\" style=\"width:70%;padding:10px;\">Run result will be here...</div>";
            $snippet_code = "";
        } else {
            $snippet_code = $snippet_code . $line;
            $text = str_replace("&", "&amp;", $line);
            $text = str_replace("<", "&lt;", $text);
            $text = str_replace(">", "&gt;", $text);
            $output .= "$text<br>";
            if (str_contains($line, '<script>')){
                $write_executable = true;
                $function_name = bin2hex(random_bytes(4));
                $executable_code = $executable_code . "function f$function_name (){";
                $functions_to_do[] = $function_name;
            }elseif (str_contains($line, '</script>')){
                $write_executable = false;
                $executable_code = $executable_code . "}\n";
            }elseif ($write_executable){
                $executable_code = $executable_code . $line;
            }else{
                $show_parts = $show_parts . $line;
            }
        }
    }
}
echo "$output<script src=\"https://cs.tru.ca/~T00712793/prism.js\"></script><script>$executable_code</script></body>";
?>