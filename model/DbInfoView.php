<?php

namespace gratz;

/**
 * Description of DbInfoView
 *
 * @author ondrej.gratz
 */
class DbInfoView {
    
    private $pdo;
        
    public function __construct($pdo) 
    {
        if (!$pdo)
        {
            throw new \Exception("No PDO object passed to DbInfoView constructor");
        }
        $this->pdo = $pdo;
        
        $this->Load();
    }
    
    public $FirstName;
    public $LastName;
    public $UniversityName;
    public $FacultyName;
    public $Email;
    
    public function getFullName()
    {
        return $this->FirstName . " " . $this->LastName;
    }
    
    private function SetPropertiesFromDb($item)
    {
        $this->FirstName = filter_var($item->FirstName, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $this->LastName = filter_var($item->LastName, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $this->UniversityName = filter_var($item->UniversityName, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $this->FacultyName = filter_var($item->FacultyName, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $this->Email = filter_var($item->Email, FILTER_SANITIZE_EMAIL);
    }
    
    private function Load()
    {
        $sth = $this->pdo->query("SELECT * FROM DbInfoView;", \PDO::FETCH_OBJ);
        if (!$sth)
        {
            throw new \Exception("Unable to load personal information");
        }

        $item = $sth->fetch();
        $sth->closeCursor();
       
        if (!$item) 
        {
            throw new \Exception("Personal information was not found in database");
        }
        
        $this->SetPropertiesFromDb($item);
    }

}
