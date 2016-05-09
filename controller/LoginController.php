<?php
namespace gratz;

class LoginController extends BaseController {
    
    public function __construct($model) 
    {
        parent::__construct($model);
    }
    
    public function LoginAdmin()
    {
        if (session_status() == PHP_SESSION_NONE)
        {
            session_start();
        }
        $_SESSION['IS_ADMIN'] = \TRUE;
    }
    
    public function LogoutAdmin()
    {
        if (session_status() == PHP_SESSION_ACTIVE)
        {
            session_unset();
        }
    }
    
    public function ProcessPOST()
    {
        $password = \filter_input(\INPUT_POST, 'AdminPassword');
        if (!is_string($password))
        {
            throw new \GratzException("No password specified");
        }
        
        if ((hash("sha256", "xxx" . $password) == $this->model->password))
        {
            $this->LoginAdmin();
            return "login_success";
        }
        else
        {
            $this->LogoutAdmin();
            $this->model->setError("Login failed.");
            $this->model->RefreshNavItems();
            return FALSE;
        }
    }
}
