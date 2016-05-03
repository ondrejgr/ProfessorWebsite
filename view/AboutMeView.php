<?php
namespace gratz;

include 'view/BaseView.php';

class AboutMeView extends BaseView 
{

    
}

$model = new \gratz\BaseModel("AboutMe");
$controller = new \gratz\BaseController($model);
$view = new \gratz\AboutMeView($model, $controller);
$view->Generate();
