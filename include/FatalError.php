<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Server Error</title>
        <style>
            p.error
            {
                color: red;
                font-weight: bold;
                font-size: 1.5em;
            }
        </style>
    </head>
    <body>
        <h1>Server Error Occurred</h1>
<?php
    if (!isset($message))
    {
        $message = "Unknown error occurred";
    }
    echo "        <p class=\"error\">$message.</p>\n";
?>
    </body>
</html>
<?php
    die();
