<?php
namespace gratz;

include 'include/Database.php';
include 'model/BaseModel.php';
include 'controller/BaseController.php';

abstract class BaseView {
    protected $url;
    
    protected $model;
    protected $controller;
    
    protected $is_admin_required = \FALSE;
    protected $do_not_cache = \FALSE;
    
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
        $this->url = "index.php?view=" . $this->viewName;
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

    private function PutCustomHeaders()
    {
        if ($this->do_not_cache)
        {
            header('Pragma: no-cache');
            header('Expires: Fri, 30 Oct 1998 14:19:41 GMT');
            header('Cache-Control: no-cache, must-revalidate');
        }
    }
    
    public function Redirect($url)
    {
        header( 'HTTP/1.1 303 See Other' );
        header( "Location: " . $url );
        die();
    }
    
    private function ProcessMethods()
    {        
        if (filter_input(INPUT_SERVER, 'REQUEST_METHOD', FILTER_SANITIZE_STRING) === 'POST')
        {
            $post_result = $this->controller->ProcessPOST();
            if ($post_result)
            {
                $this->Redirect(BASE_URL . "index.php?view=" . $this->viewName . "&info=$post_result");
                return;
            }
            else 
            {
                $this->PutCustomHeaders();
                $this->setInfoMessageKey("");
                $this->setIsPostBack(\TRUE);
            }
        }
        if (filter_input(INPUT_SERVER, 'REQUEST_METHOD', FILTER_SANITIZE_STRING) === 'GET')
        {
            $this->PutCustomHeaders();
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
        <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css"/>
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
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
                <div class="portraitSmall"><img src="img/portrait_small.png" alt="<?php echo $this->model->dbInfo->getFullName() ?>" /></div>
                <div class="fullName"><?php echo $this->model->dbInfo->getFullName() ?></div>
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
                    <div id="universityName"><?php echo $this->model->dbInfo->UniversityName ?></div>
                    <div id="facultyName"><?php echo $this->model->dbInfo->FacultyName ?></div>
                </div>
                <div id="smallNavHeader">
                    <div class="portrait"><img src="img/portrait_small.png" alt="<?php echo $this->model->dbInfo->getFullName() ?>" /></div>
                    <div class="fullName"><?php echo $this->model->dbInfo->getFullName() ?></div>
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
                <p>&copy;&nbsp;<?php echo '<a href="mailto:' . $this->model->dbInfo->Email . '" title="' . $this->model->dbInfo->getFullName() . '">' . $this->model->dbInfo->getFullName() . '</a>' ?> 2016</p>
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
    
    protected function OnRenderBeforeContent()
    {
    }

    protected function RenderContent()
    {
?>
                <div class="content">
<?php
        if (is_string($this->model->content) && strlen($this->model->content) > 0)
        {
            $this->OnRenderBeforeContent();

            $array = explode("\n", str_replace("\r", '', $this->model->content));
            if (!$array)
            {
                return FALSE;
            }
            
            foreach ($array as $item)
            {
                echo "                    <p>$item</p>\n";
            }
        }
?>
                </div>
<?php
    }
    
    protected function RenderCollectionItem($item)
    {
        foreach ($item as $name => $value)
        {
?>
                                <div data-prop-name="<?php echo $name ?>"><?php echo $value ?></div>
<?php
        }
    }
    
    protected function RenderCollection($collection)
    {
        if (!is_a($collection, '\Gratz\ItemsCollection'))
        {
            throw new \GratzException("Unable to render collection - invalid object type");
        }
?>
                    <section class="<?php echo (new \ReflectionClass($collection))->getShortName() ?>">
                        <div class="collection-title"><?php echo $collection->title ?></div>
                        <ul>
<?php
        foreach ($collection->data as $item)
        {
?>
                            <li class="collection-row">
<?php
            $this->RenderCollectionItem($item);
?>

                            </li>
<?php
        }
?>
                        </ul>
                    </section>
<?php
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
