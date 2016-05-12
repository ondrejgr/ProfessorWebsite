<?php
namespace gratz;

include 'view/BaseView.php';
include 'model/ContactModel.php';

class ContactView extends BaseView 
{
    public function __construct($model, $controller) 
    {
        parent::__construct($model, $controller);
    }

    
    protected function OnGenerateContent()
    {
        $this->RenderContent();
    }
}

$model = new \gratz\ContactModel("Contact");
$controller = new \gratz\BaseController($model);
$view = new \gratz\ContactView($model, $controller);
$view->Generate();
