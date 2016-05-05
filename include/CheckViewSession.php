<?php
if (!isset($_SESSION['IS_ADMIN']) || !is_bool($_SESSION['IS_ADMIN'])
        || !$_SESSION['IS_ADMIN']) 
{
    header('HTTP/1.1 404 Not Found');
?>
<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Error 404</title>
    </head>
    <body>
        <h1>Content Not Found</h1>
        <h2>Requested resource was not found or you have no rights to access it.</h2>
    </body>
</html>
<?php
    die();
}