<?php require 'include/ErrorHandling.php' ?>
<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Create Database Schema</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
        <style>
            #results
            {
            }
            .result_error
            {
                color: red;
                font-size: 1em;
            }
            .result_success
            {
                color: blue;
                font-size: 1em;
            }
            p.error
            {
                color: red;
                font-weight: bold;
                font-size: 1.5em;
            }
            form
            {
                display: table;
                padding: 0.5em;
                border: solid silver;
            }
            form div
            {
                display: table-row;
                padding: 0.25em;
            }
            form div div
            {
                display: table-cell;
            }
            input[type=submit]
            {
                width: 10em;
            }
            input[type=reset]
            {
                width: 10em;
            }
        </style>
    </head>
    <body>
        <h1>Create Database Schema</h1>
<?php
    try
    {
        if (filter_input(INPUT_SERVER, 'REQUEST_METHOD', FILTER_SANITIZE_STRING) === 'POST')
        {
            if (!isset($_POST['SQLUserName']) || !is_string($_POST['SQLUserName']) || (strlen($_POST['SQLUserName']) === 0))
            {
                throw new GratzException("No SQL user name specified");
            }
            $userName = filter_input(INPUT_POST, 'SQLUserName');
            
            if (!isset($_POST['SQLPassword']) || !is_string($_POST['SQLPassword']))
            {
                throw new GratzException("No SQL password specified");
            }
            $password =  filter_input(INPUT_POST, 'SQLPassword');
            
            require 'config/sql/DbSchemaCreator.php';
            $db_schema_creator = new DbSchemaCreator();
            $db_schema_creator->CreateDbSchema($userName, $password, "config/sql");
        }
        else
        {
?>
        <form method="POST">
            <div>
                <div><label accesskey="U" for="SQLUserName">SQL user name:</label></div>
                <div><input type="text" id="SQLUserName" name="SQLUserName" value="ba072f630cdf08" autofocus required /></div>
            </div>
            <div>
                <div><label accesskey="P" for="SQLPassword">SQL password:</label></div>
                <div><input type="password" id="SQLPassword" name="SQLPassword"/></div>
            </div>
            <div>
                <div><input type="submit" value="Create Schema"/></div>
                <div><input type="reset" value="Reset Form" onclick="$(SQLUserName).focus()"/></div>
            </div>
        </form>
<?php
        }
    } 
    catch (GratzException $ex) 
    {
        $message = $ex->getMessage();
        echo "        <p class=\"error\">$message.</p>\n";
    }
    catch (Exception $ex) 
    {
        $message = $ex->getMessage();
        echo "        <p class=\"error\">Internal server error occurred: $message.</p>\n";
    }
?>
    </body>
</html>
