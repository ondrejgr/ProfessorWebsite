<?php
namespace gratz;

class BaseController {
    protected $model;
    
    public function __construct($model) 
    {
        if (is_null($model) || !($model instanceof \gratz\BaseModel))
        {
            throw new Exception("No valid model instance has been passed to controler");
        }
        $this->model = $model;
    }
}
