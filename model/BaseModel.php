<?php
namespace gratz;
include "model/NavItem.php";
include "model/Person.php";

class BaseModel {
    /* @var $pdo PDO */
    protected $pdo = NULL;
    protected $cmdGetDbInfoItem;
    
    public $navItems = array();
    public $person;
   
    
    public $error;
    public function setError($error)
    {
        $this->error = $error;
    }
    
    public $info;
    public function setInfo($info)
    {
        $this->info = $info;
    }
    
    public $lang = 'en';
    function setLang($lang)
    {
        $this->lang = $lang;
    }
    
    public $pageName = '';
    function setPageName($pageName)
    {
        $this->pageName = $pageName;
    }
    
    public $webTitle = '';
    function setWebTitle($webTitle)
    {
        $this->webTitle = $webTitle;
    }
    
    public $pageTitle = '';
    function setPageTitle($pageTitle)
    {
        $this->pageTitle = $pageTitle;
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
    
    private function LoadPerson()
    {
        $sth = $this->pdo->query("SELECT * FROM DbInfoView;", \PDO::FETCH_CLASS, "\gratz\Person");
        if (!$sth)
        {
            throw new \Exception("Unable to load personal information");
        }

        $this->person = $sth->fetch();
        $sth->closeCursor();
       
        if (!is_a($this->person, "\gratz\Person")) 
        {
            throw new \Exception("Personal information was not found in database");
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
   
    
    private function LoadNavItems()
    {
        $this->navItems = array();
        $adminFilter = '';
        if (!$this->IsAdminLoggedIn())
        {
            $adminFilter = ' AND IsAdmin = 0';
            $url = 'Name';
        }
        else
        {
            $url = "Name, CASE WHEN IsAdmin = 0 THEN 'Edit' ELSE '' END";
        }
        $sth = $this->pdo->query("SELECT Name, Title, NavIndex, IsAdmin, CONCAT('index.php?view=', " . $url . ") Url FROM Pages WHERE NavIndex > 0" . $adminFilter . " ORDER BY NavIndex;", 
                    \PDO::FETCH_CLASS, "\gratz\NavItem");
        if (!$sth)
        {
            throw new \Exception("Unable to load NavItems");
        }

        while ($navItem = $sth->fetch())
        {
            $this->navItems[] = $navItem;
        }
        $sth->closeCursor();
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
    
    private function LoadData()
    {
        $this->setWebTitle($this->GetDbInfoItem('Title'));
        $this->LoadPerson();
        if (is_string($this->pageName) && (strlen($this->pageName) > 0)) 
        {
            $this->LoadPageData();
        }
        $this->LoadNavItems();
        $this->OnLoadData();
    }
    
    protected function OnLoadData()
    {
        
    }


    protected function GetDbInfoItem($key)
    {
        if (!is_string($key) || (strlen($key) == 0))
        {
            throw new \Exception("No valid key parameter has been passed to GetDbInfoItem method");
        }
        $this->cmdGetDbInfoItem->execute(array(':InfoKey' => $key));
        $value = $this->cmdGetDbInfoItem->fetchColumn();
        $this->cmdGetDbInfoItem->closeCursor();
        if ($value && is_string($value))
        {
            return $value;
        }
        else
        {
            return '';
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
    }
    
    private function CloseDbConnection()
    {
        $this->cmdGetDbInfoItem = NULL;
        $this->pdo = NULL;
    }
    
    public function Refresh()
    {
        $this->LoadData();
    }
    
    public function RefreshNavItems()
    {
        $this->LoadNavItems();
    }
    
    public function __construct($pageName) 
    {
        $this->pageName = $pageName;
        
        $this->OpenDbConnection();
        $this->LoadData();
    }
    
    function __destruct() 
    {
       $this->CloseDbConnection();
    }
}
