<?php
namespace gratz;

/**
 * Description of Person
 *
 * @author ondrej.gratz
 */
class PersonModel extends \gratz\BaseModel {
    public function __construct($pageName) 
    {
        parent::__construct($pageName, TRUE);
    }
    
    function __destruct() 
    {
        parent::__destruct();
    }
    
    public $FirstName;
    public $LastName;
    public $UniversityName;
    public $FacultyName;
    public $Email;
    
    public function setFirstName($value)
    {
        $this->FirstName = $value;
    }

    public function setLastName($value)
    {
        $this->LastName = $value;
    }
    
    public function setUniversityName($value)
    {
        $this->UniversityName = $value;
    }
    
    public function setFacultyName($value)
    {
        $this->FacultyName = $value;
    }
    
    public function setEmail($value)
    {
        $this->Email = $value;
    }
    
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
            
    protected function OnValidateData()
    {
        if (!is_string($this->FirstName) || strlen($this->FirstName) == 0)
        {
            throw new \GratzValidationException("First name must be specified");
        }
        if (!is_string($this->LastName) || strlen($this->LastName) == 0)
        {
            throw new \GratzValidationException("Last name must be specified");
        }
        if (!is_string($this->UniversityName) || strlen($this->UniversityName) == 0)
        {
            throw new \GratzValidationException("University name must be specified");
        }
        $this->Email = filter_var($this->Email, FILTER_VALIDATE_EMAIL);
        if (!$this->Email)
        {
            throw new \GratzValidationException("Valid E-mail address must be provided");
        }
    }
    
    protected function OnLoadData()
    {
        parent::OnLoadData();
        
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
    
    protected function OnSaveData()
    {
        $this->SetDbInfoItem("FirstName", $this->FirstName);
        $this->SetDbInfoItem("LastName", $this->LastName);
        $this->SetDbInfoItem("UniversityName", $this->UniversityName);
        $this->SetDbInfoItem("FacultyName", $this->FacultyName);
        $this->SetDbInfoItem("Email", $this->Email);
    }
}
