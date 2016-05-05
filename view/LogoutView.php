<?php
namespace gratz;

include 'view/BaseView.php';
include 'controller/LogoutController.php';

class LogoutView extends BaseView 
{
    public function __construct($model, $controller) 
    {
        parent::__construct($model, $controller);
    }
   
    protected function OnGenerateContent()
    {
        $this->GenerateMessages();
    }
}

$model = new \gratz\BaseModel("Logout");
$controller = new \gratz\LogoutController($model);
$view = new \gratz\LogoutView($model, $controller);
$view->Generate();
