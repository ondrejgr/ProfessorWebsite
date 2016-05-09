<?php
namespace gratz;

include 'include/Database.php';
include 'model/BaseModel.php';
include 'controller/BaseController.php';

abstract class BaseView {
    protected $model;
    protected $controller;
    
    protected $is_admin_required = \FALSE;
    
    public $isPostBack = \FALSE;
    public function setIsPostBack($isPostBack)
    {
        $this->isPostBack = $isPostBack;
    }
    
    public $infoMessageKey;
    public function setInfoMessageKey($infoMessageKey)
    {
        $this->infoMessageKey = $infoMessageKey;
    }
    
    public $viewName;

    public function __construct($model, $controller) 
    {
        $this->viewName = GetViewName();
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
    
    private function SetInfoMessageKeyFromGET()
    {
        if (isset($_GET['info']) && is_string($_GET['info']))
        {
            $this->setInfoMessageKey(filter_input(INPUT_GET, 'info', FILTER_SANITIZE_STRING));
        }
    }
    
    protected function CheckAdminAccess()
    {
        if ($this->is_admin_required)
        {
            return $this->model->IsAdminLoggedIn();
        }
        else
        {
            return \TRUE;
        }
    }
    
    protected function GeneratePageNotFoundContent()
    {
?>
                <h2>Requested page was not found or you have no rights to access it.</h2>
<?php
    }

    private function ProcessMethods()
    {        
        if (filter_input(INPUT_SERVER, 'REQUEST_METHOD', FILTER_SANITIZE_STRING) === 'POST')
        {
            $post_result = $this->controller->ProcessPOST();
            if ($post_result)
            {
                header( 'HTTP/1.1 303 See Other' );
                header( "Location: " . BASE_URL . "index.php?view=" . $this->viewName . "&info=$post_result" );
                die();
            }
            else 
            {
                $this->setInfoMessageKey("");
            }
            $this->setIsPostBack(\TRUE);
        }
        if (filter_input(INPUT_SERVER, 'REQUEST_METHOD', FILTER_SANITIZE_STRING) === 'GET')
        {
            $this->SetInfoMessageKeyFromGET();
            $this->controller->ProcessGET();
            $this->setIsPostBack($this->InfoMessageExists());
        }            
    }
    
    public function Generate()
    { 
        $this->ProcessMethods();
?>
<!DOCTYPE html>

<html <?php echo "lang=\"" . $this->model->lang . "\"" ?>>
    <head>
        <meta charset="UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1"/>

        <title><?php echo $this->model->getTitle() ?></title>
       
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
<?php 
    $this->GenerateStyleSheets();
    $this->GenerateHead();             
?>
    </head>
    <body>
      <div id="container">
<?php 
    $this->GenerateBody();             
?>
      </div>
    </body>
</html>
<?php
    }
    
    private function GenerateStyleSheets()
    {
?>
        <link rel="stylesheet" href="style/main.css"/>
        <link rel="stylesheet" href="style/small.css" media="screen and (max-width: 768px)"/>        
        <link rel="stylesheet" href="style/large.css" media="screen and (min-width: 768px)"/>        
        <link rel="stylesheet" href="style/print.css" media="print"/>
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
            $this->GenerateLeftBar();
            $this->GenerateCenter();
            
            $this->GenerateScript();
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
    
    private function GenerateLeftBar()
    {
?>            
        <div id="left-bar">
<?php
            $this->GenerateNavHeader();
            $this->GenerateNav();
?>      
        </div>
<?php
    }
    
    private function GenerateCenter()
    {
?>            
        <div id="center">
<?php
            $this->GenerateContentHeader();
            $this->GenerateContent();
            $this->GenerateContentFooter();
?>      
        </div>
        <div id="footer"></div>
<?php
    }
    
    private function GenerateNavHeader()
    {
?>
            <header>
                <div class="portraitSmall"><img src="img/portrait_small.png" alt="<?php echo $this->model->person->FullName ?>" /></div>
                <div class="fullName"><?php echo $this->model->person->FullName ?></div>
            </header>
<?php
    }
   
    private function GenerateNav()
    {
?>
            <nav>
<?php
                $this->OnGenerateNav();
?>                
            </nav>
<?php
    }

    private function GenerateContentHeader()
    {
?>
            <header>
                <div id="organisationName">
                    <div id="navButton"><input id="cmdNavButton" name="navButton" type="button" value="="/></div>
                    <div id="universityName"><?php echo $this->model->person->UniversityName ?></div>
                    <div id="facultyName"><?php echo $this->model->person->FacultyName ?></div>
                </div>
                <div id="smallNavHeader">
                    <div class="portrait"><img src="img/portrait_small.png" alt="<?php echo $this->model->person->FullName ?>" /></div>
                    <div class="fullName"><?php echo $this->model->person->FullName ?></div>
                </div>
            </header>
<?php
    }
    
    protected function GenerateContent()
    {
?>
            <main>
<?php
        if ($this->CheckAdminAccess())
        {
?>
                <h1><?php echo $this->model->pageTitle ?></h1><hr/>
<?php
                $this->OnGenerateContent();
        }
        else
        {
                $this->GeneratePageNotFoundContent();
        }
?>
            </main>
<?php
    }
    
    private function GenerateContentFooter()
    {
?>
            <footer>
                <p>&copy;&nbsp;<?php echo '<a href="mailto:' . $this->model->person->Email . '" title="' . $this->model->person->FullName . '">' . $this->model->person->FullName . '</a>' ?> 2016</p>
            </footer>
<?php
    }
    
    private function GenerateScript()
    {
?>
        <script>
            $(document).ready(
    function()
    {
        var obj = $("nav").find("a[data-view-name='<?php echo $this->model->pageName ?>']");
        if (obj)
            obj.addClass("active-nav-item");
        
        $("#cmdNavButton").click(function(){
            $("#left-bar").toggle();
        });
<?php
        $this->OnGenerateScript();
?>        
        return false;
    });
        </script>
<?php
    }
    
    private function InfoMessageExists()
    {
        return strlen($this->GenerateInfoMessage()) > 0;
    }
    
    private function GenerateInfoMessage()
    {
        $key = $this->infoMessageKey;
        if (!is_string($key) || strlen($key) == 0)
        {
            return "";
        }
        
        if ($key == "data_saved")
        {
            return "Data saved.";
        }
        if ($key == "login_success")
        {
            return "Login success.";
        }

        return "";
    }
    
    public function GenerateMessages()
    {
        $error = $this->model->error;
        $info = $this->model->info;
        
        if (is_string($error) && strlen($error) > 0)
        {
            echo "                <p class=\"error\">$error</p>\n";
        }
        if (is_string($info) && strlen($info) > 0)
        {
            echo "                <p class=\"info\">$info</p>\n";
        }

        $message = $this->GenerateInfoMessage();
        if (strlen($message) > 0)
        {
            echo "                <p class=\"info\">$message</p>\n";
        }
    }
    
    protected function OnGenerateHead()
    {
    }
    
    protected function OnGenerateNav()
    {
?>
<?php
        foreach($this->model->navItems as $navItem)
        {
            echo "                <a href=\"$navItem->Url\" title=\"$navItem->Title\" data-view-name=\"$navItem->Name\">$navItem->Title</a>\n";
        }
    }
    
    protected function OnGenerateContent()
    {
        
    }
    
    protected function OnGenerateScript()
    {
    }
}
