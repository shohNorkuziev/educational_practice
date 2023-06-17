<?php
    $text = 'PHp рулит!';
    if (preg_match('/PHP/i', $text))
    {
        $output = '$text содержит строку &ldquo;PHP&rdquo;.';
    }
    else
    {
        $output = '$text не содержит строку &ldquo;PHP&rdquo;.';
    }
    include 'output.html.php'
?>