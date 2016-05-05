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

    protected function OnGenerateHead()
    {
?>
        <style>
            #results
            {
            }
            .result_error
            {
                color: red;
                font-size: 1em;
            }
            .result_success
            {
                color: blue;
                font-size: 1em;
            }
            p.error
            {
                color: red;
                font-weight: bold;
                font-size: 1.5em;
            }
            form
            {
                display: table;
                padding: 0.5em;
                border: solid silver;
            }
            form div
            {
                display: table-row;
                padding: 0.25em;
            }
            form div div
            {
                display: table-cell;
            }
            input[type=submit]
            {
                width: 10em;
            }
            input[type=reset]
            {
                width: 10em;
            }
        </style>
<?php
    }
    
    protected function OnGenerateContent()
    {
        $this->GenerateMessages();
        if (!$this->isPostBack)
        {
?>
                <form method="POST">
                    <div>
                        <div><label accesskey="P" for="AdminPassword">Admin password:</label></div>
                        <div><input type="password" id="AdminPassword" name="AdminPassword" value="" autofocus /></div>
                    </div>
                    <div>
                        <div><input type="submit" value="Login"/></div>
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
