<?php
namespace gratz;

class PersonEditController extends BaseController {
    
    public function __construct($model) 
    {
        parent::__construct($model);
    }
    
    public function ProcessPOST()
    {
        try
        {
            $this->UpdatePerson();
            
            return "data_saved";
        }
        catch (\Exception $ex) 
        {
            $message = $ex->getMessage();
            $this->model->setError("Error saving data: $message.");
            return FALSE;
        }
    }
    
    private function UpdatePerson()
    {
        $this->model->setLastName(filter_input(INPUT_POST, "LastName"));
        $this->model->setFirstName(filter_input(INPUT_POST, "FirstName"));
        $this->model->setUniversityName(filter_input(INPUT_POST, "UniversityName"));
        $this->model->setFacultyName(filter_input(INPUT_POST, "FacultyName"));
        $this->model->setEmail(filter_input(INPUT_POST, "Email"));
        $this->model->SaveData();
    }
}
