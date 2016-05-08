<?php
namespace gratz;

/**
 * Description of Person
 *
 * @author ondrej.gratz
 */
class Person 
{
    private $pdo;
    
    public function __construct($pdo) 
    {
        $this->pdo = $pdo;
        $this->Load();
    }
    
    public $FirstName;
    public $LastName;
    public $FullName;
    public $UniversityName;
    public $FacultyName;
    public $Email;
    
    private function PrepareForDisplay($item)
    {
        $this->FirstName = filter_var($item->FirstName, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $this->LastName = filter_var($item->LastName, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $this->FullName = filter_var($item->FullName, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $this->UniversityName = filter_var($item->UniversityName, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $this->FacultyName = filter_var($item->FacultyName, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $this->Email = filter_var($item->Email, FILTER_SANITIZE_EMAIL);
    }
    
    public function Load()
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
        
        $this->PrepareForDisplay($item);
    }
}
