<?php
namespace gratz;

class BaseModel {
    /* @var $pdo PDO */
    protected $pdo = NULL;
    protected $cmdGetDbInfoItem;
    
    public $lang = 'en';
    function setLang($lang)
    {
        $this->lang = $lang;
    }
    
    public $title;
    function setTitle($title)
    {
        $this->title = $title;
    }
    
    protected function LoadData()
    {
        
    }
    
    protected function GetDbInfoItem($key)
    {
        if (!isset($key) || !is_string($key) || (strlen($key) == 0))
        {
            throw new Exception("No valid key parameter has been passed to GetDbInfoItem method");
        }

    }
    
    private function OpenDbConnection()
    {
        try
        {
            $this->pdo = \Database::GetPDO();
        } 
        catch (Exception $ex) 
        {
            $errmsg = $ex->getMessage();
            throw new Exception("Model was unable to open database connection: " . $errmsg);
        }
        
        $this->cmdGetDbInfoItem = $this->pdo->prepare("SELECT InfoValue FROM DbInfo WHERE InfoKey = :InfoKey;");
    }
    
    private function CloseDbConnection()
    {
        $this->cmdGetDbInfoItem = NULL;
        $this->pdo = NULL;
    }
    
    public function __construct() 
    {
        $this->OpenDbConnection();
        $this->LoadData();
    }
    
    function __destruct() 
    {
       $this->CloseDbConnection();
    }
}
