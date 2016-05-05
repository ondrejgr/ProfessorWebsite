<?php

namespace gratz;


class LoginModel extends \gratz\BaseModel {
    public function __construct($pageName) 
    {
        parent::__construct($pageName);
    }
    
    function __destruct() 
    {
        parent::__destruct();
    }

    public $password;
    private function setPassword($password)
    {
        $this->password = $password;
    }
    
    protected function OnLoadData()
    {
        $this->setPassword($this->GetDbInfoItem("Password"));
    }

}
