<?php
namespace gratz;

class BaseView {
    protected $model;
    protected $controller;
    
    public function __construct($model, $controller) 
    {
        if (is_null($model) || !($model instanceof \gratz\BaseModel))
        {
            throw new Exception("No valid model instance has been passed to view");
        }
        if (is_null($controller) || !($controller instanceof \gratz\BaseController))
        {
            throw new Exception("No valid controller instance has been passed to view");
        }

        $this->model = $model;
        $this->controller = $controller;
    }
    
    public function Render()
    {

    }
}
