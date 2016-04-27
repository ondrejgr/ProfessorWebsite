<?php 
include 'include/Database.php';
include 'model/BaseModel.php';
include 'controller/BaseController.php';
include 'view/BaseView.php';

class mvc {
    public $model;
    public $view;
    public $controller;
    
    private function CreateEmptyMVC()
    {
        $this->model = new \gratz\BaseModel();
        $this->controller = new \gratz\BaseController($this->model);
        $this->view = new \gratz\BaseView($this->model, $this->controller);
    }
    
    function DispatchRequest()
    {
        $this->CreateEmptyMVC();
    }
}

#if (isset($_GET['view']) && is_string($_GET['view']))
#{
#    $viewName = filter_input(INPUT_GET, 'view');
#}
