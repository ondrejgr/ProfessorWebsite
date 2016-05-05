<?php
namespace gratz;

include 'view/BaseView.php';

class PageNotFoundView extends BaseView 
{
    public function __construct($model, $controller) 
    {
        parent::__construct($model, $controller);
    }

    protected function OnGenerateContent()
    {
        $this->GeneratePageNotFoundContent();
    }
}

$model = new \gratz\BaseModel("PageNotFound");
$controller = new \gratz\BaseController($model);
$view = new \gratz\PageNotFoundView($model, $controller);
$view->Generate();
