<?php
namespace gratz;

include 'include/Database.php';
include 'model/BaseModel.php';
include 'controller/BaseController.php';

abstract class BaseView {
    protected $model;
    protected $controller;
    
    public function __construct($model, $controller) 
    {
        if (is_null($model) || !($model instanceof \gratz\BaseModel))
        {
            throw new \Exception("No valid model instance has been passed to view");
        }
        if (is_null($controller) || !($controller instanceof \gratz\BaseController))
        {
            throw new \Exception("No valid controller instance has been passed to view");
        }

        $this->model = $model;
        $this->controller = $controller;
    }
    
    public function Generate()
    { 
?>
<!DOCTYPE html>

<html <?php echo "lang=\"" . $this->model->lang . "\"" ?>>
    <head>
        <meta charset="UTF-8"/>
        <title><?php echo $this->model->getTitle() ?></title>
        <link rel="stylesheet" href="style/main.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
<?php 
    $this->GenerateHead();             
?>
    </head>
    <body>
<?php 
    $this->GenerateBody();             
?>
    </body>
</html>
<?php
    }
    
    private function GenerateHead()
    {
        try
        {
            $this->OnGenerateHead();             
        } 
        catch (\GratzException $ex) 
        {
            $message = $ex->getMessage();
            echo "\n</head><body>\n        <p class=\"error\">$message.</p>\n";
        }
        catch (\Exception $ex) 
        {
            $message = $ex->getMessage();
            echo "\n</head><body>\n        <p class=\"error\">Internal server error occurred: $message.</p>\n";
        }
    }
    
    private function GenerateBody()
    {
        try
        {
            $this->OnGenerateNav();
            $this->OnGenerateBody();             
        } 
        catch (\GratzException $ex) 
        {
            $message = $ex->getMessage();
            echo "        <p class=\"error\">$message.</p>\n";
        }
        catch (\Exception $ex) 
        {
            $message = $ex->getMessage();
            echo "        <p class=\"error\">Internal server error occurred: $message.</p>\n";
        }
    }
    
    protected function OnGenerateNav()
    {
?>
        <div id="nav">
            <nav>
<?php
        foreach($this->model->navItems as $navItem)
        {
            echo "                <a href=\"$navItem->Url\" title=\"$navItem->Title\">$navItem->Title</a>\n";
        }
?>                
            </nav>
        </div>
<?php
    }
    
    protected function OnGenerateHead()
    {
        
    }
    
    protected function OnGenerateBody()
    {
    
    }
}
