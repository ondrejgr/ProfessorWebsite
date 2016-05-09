<?php
namespace gratz;
include "model/NavItemsLoader.php";
include "model/DbInfoView.php";

class BaseModel {
    /* @var $pdo PDO */
    protected $pdo = NULL;
    protected $cmdGetDbInfoItem;
    protected $cmdSetDbInfoItem;
    
    public $navItems = array();
    public $dbInfo;
   
    public $isEditor = FALSE;
    
    public $error;
    public function setError($error)
    {
        $value = filter_var($error, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (!$value)
        {
            $value = "";
        }
        $this->error = $value;
    }
    
    public $info;
    public function setInfo($info)
    {
        $value = filter_var($info, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (!$value)
        {
            $value = "";
        }
        $this->info = $value;
    }
    
    public $lang = 'en';
    
    public $pageName = '';
    function setPageName($pageName)
    {
        $value = filter_var($pageName, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (!$value)
        {
            $value = "";
        }
        $this->pageName = $value;
    }
    
    public $webTitle = '';
    function setWebTitle($webTitle)
    {
        $value = filter_var($webTitle, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (!$value)
        {
            $value = "";
        }
        $this->webTitle = $value;
    }
    
    public $pageTitle = '';
    function setPageTitle($pageTitle)
    {
        $value = filter_var($pageTitle, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (!$value)
        {
            $value = "";
        }
        $this->pageTitle = $value;
    }

    function getTitle()
    {
        if (is_string($this->pageTitle) && strlen($this->pageTitle) > 0)
        {
            return $this->webTitle . " | " . $this->pageTitle;
        }
        else
        {
            return $this->webTitle;
        }            
    }

    public function IsAdminLoggedIn()
    {
        if (session_status() == PHP_SESSION_NONE)
        {
            session_start();
        }
        return isset($_SESSION['IS_ADMIN']) && is_bool($_SESSION['IS_ADMIN']) && $_SESSION['IS_ADMIN'];
    }
        
    private function LoadPageData()
    {
        $sth = $this->pdo->prepare("SELECT Name, Title FROM Pages WHERE Name = :Name;");
        $sth->execute(array(':Name' => $this->pageName));
        
        $pageData = $sth->fetch(\PDO::FETCH_OBJ);
        if (!$pageData)
        {
            throw new \Exception("No data found for requested page");
        }
        
        $this->setPageTitle($pageData->Title);

        $sth->closeCursor();
    }

    public function Refresh()
    {
        $this->LoadData();
    }
    
    public function RefreshNavItems()
    {
        $this->LoadNavItems();
    }
    
    private function LoadData()
    {
        $this->setWebTitle($this->GetDbInfoItem('Title'));
        $this->dbInfo = new \gratz\DbInfoView($this->pdo);
        if (is_string($this->pageName) && (strlen($this->pageName) > 0)) 
        {
            $this->LoadPageData();
        }
        $this->LoadNavItems();
        $this->OnLoadData();
    }
    
    public function SaveData()
    {
        $this->OnValidateData();
        $this->OnSaveData();
    }
    
    private function LoadNavItems()
    {
        $o = new NavItemsLoader($this->pdo, $this->IsAdminLoggedIn());
        $this->navItems = $o->GetNavItems();
    }
    
    protected function OnLoadData()
    {
        
    }
    
    protected function OnSaveData()
    {
        throw new \Exception("Save data operation is not implemented");
    }
    
    protected function OnValidateData()
    {
        
    }

    private function CheckKey($key)
    {
        if (!is_string($key) || (strlen($key) == 0))
        {
            throw new \Exception("No valid key parameter has been passed to DbInfoItem method");
        }
    }

    protected function GetDbInfoItem($key, $sanitize = TRUE)
    {
        $this->CheckKey($key);
        $this->cmdGetDbInfoItem->execute(array(':InfoKey' => $key));
        
        if ($sanitize)
        {
            $value = filter_var($this->cmdGetDbInfoItem->fetchColumn(), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        }
        else
        {
            $value = $this->cmdGetDbInfoItem->fetchColumn();
        }
        $this->cmdGetDbInfoItem->closeCursor();
        
        if ($value)
        {
            return $value;
        }
        else 
        {
            return "";
        }
    }
    
    protected function SetDbInfoItem($key, $value)
    {
        $this->CheckKey($key);
        if (!is_string($value))
        {
            $value = "";
        }
        if (!$this->cmdSetDbInfoItem->execute(array(':InfoKey' => $key, ':InfoValue' => $value)))
        {
            throw new \GratzException("Database insert failed in method SetDbInfoItem");
        }
    }
    
    private function OpenDbConnection()
    {
        $this->pdo = \Database::GetPDO();
        $this->cmdGetDbInfoItem = $this->pdo->prepare("SELECT InfoValue FROM DbInfo WHERE InfoKey = :InfoKey;");
        if ($this->GetDbInfoItem('DbVersion') != 'GRATZ-AAA')
        {
            throw new \GratzException("Invalid database version");
        }
        $this->cmdSetDbInfoItem = $this->pdo->prepare("INSERT INTO DbInfo (InfoKey, InfoValue) VALUES (:InfoKey, :InfoValue) ON DUPLICATE KEY UPDATE InfoValue = :InfoValue;");
    }
    
    private function CloseDbConnection()
    {
        $this->cmdGetDbInfoItem = NULL;
        $this->pdo = NULL;
    }
    
    public function __construct($pageName, $isEditor = FALSE) 
    {
        $this->isEditor = $isEditor;
        $this->pageName = $pageName;
        
        $this->OpenDbConnection();
        $this->LoadData();
    }
    
    function __destruct() 
    {
       $this->CloseDbConnection();
    }
} 