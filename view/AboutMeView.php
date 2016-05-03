<?php
namespace gratz;

include 'view/BaseView.php';

class AboutMeView extends BaseView 
{
    protected function OnGenerateBody()
    {
    
    }
}

$model = new \gratz\BaseModel("AboutMe");
$controller = new \gratz\BaseController($model);
$view = new \gratz\AboutMeView($model, $controller);
$view->Generate();
