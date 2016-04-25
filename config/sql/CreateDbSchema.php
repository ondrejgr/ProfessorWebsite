<?php

function PutMsg($message, $is_error = FALSE)
{
    if ($is_error)
    {
        echo "            <li class=\"result_error\">$message</li>\n";
    }
    else
    {
        echo "            <li class=\"result_success\">$message</li>\n";
    }
}

function CreateDbSchema()
{
    echo "\n        <ul id=\"results\">\n";
    PutMsg("Database schema creation starting...");
    try
    {
        strpos();
        PutMsg("Opening database connection...OK");
    } 
    catch (Exception $ex) 
    {
        $errmsg = $ex->getMessage();
        PutMsg("Opening database connection...ERROR: " . $errmsg . ".", TRUE);
    }
    PutMsg("Database schema creation finished...");
    echo "\n        </ul>\n";
}
