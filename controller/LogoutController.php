<?php
namespace gratz;

class LogoutController extends BaseController {
    
    public function __construct($model) 
    {
        parent::__construct($model);
    }
    
    public function LogoutAdmin()
    {
        if (session_status() == PHP_SESSION_ACTIVE)
        {
            session_unset();
        }
    }
    
    public function ProcessGET()
    {
        $this->LogoutAdmin();
        $this->model->setInfo("Logout success.");
        $this->model->RefreshNavItems();
    }
}
