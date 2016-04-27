<?php require 'include/ErrorHandling.php' ?>
<?php
    try
    {
        include 'mvc.php'; 
        $mvc = new mvc();
        $mvc->DispatchRequest();
        
        /* @var $model BaseModel */
        $model = $mvc->model;
        /* @var $view BaseView */
        $view = $mvc->view;
        /* @var $controller BaseController */
        $controller = $mvc->controller;
    }
    catch (Exception $ex) 
    {
        $message = $ex->getMessage();
        include 'include/FatalError.php';
    }
?>
<!DOCTYPE html>

<html <?php echo "lang=\"$model->lang\"" ?>>
    <head>
        <meta charset="UTF-8">
        <title><?php echo $model->title ?></title>
        <link rel="stylesheet" href="style/main.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
    </head>
    <body>
<?php
    try
    {
        $view->RenderBody();
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
