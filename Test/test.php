<?php
$lines = file('./test.md');
foreach ($lines as $line_num => $line) {
    echo "Line #{$line_num}: " . htmlspecialchars($line);
}
?>