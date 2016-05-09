<?php
namespace gratz;

include 'view/BaseView.php';
include 'model/LoginModel.php';
include 'controller/LoginController.php';

class LoginView extends BaseView 
{
    public function __construct($model, $controller) 
    {
        parent::__construct($model, $controller);
    }
    
    protected function OnGenerateContent()
    {
        $this->GenerateMessages();
        if (!$this->isPostBack)
        {
?>
                <form method="POST">
                    <div class="form">
                        <div>
                            <div><label accesskey="P" for="AdminPassword">Admin password:</label></div>
                            <div><input type="password" id="AdminPassword" name="AdminPassword" value="" autofocus /></div>
                        </div>
                        <div>
                            <div><input type="submit" value="Login"/></div>
                        </div>
                    </div>
                </form>
<?php        
        }
    }
}

$model = new \gratz\LoginModel("Login");
$controller = new \gratz\LoginController($model);
$view = new \gratz\LoginView($model, $controller);
$view->Generate();
