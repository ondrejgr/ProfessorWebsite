<?php
namespace gratz;

class AboutMeEditController extends BaseController {
    
    public function __construct($model) 
    {
        parent::__construct($model);
    }
    
    public function ProcessPOST()
    {
        try
        {
            $content = filter_input(INPUT_POST, 'Content', FILTER_SANITIZE_STRING);
            if (!is_string($content))
            {
                throw new \GratzException("No content specified");
            }
            $this->model->updateContent($content);

            $this->UpdateAcademicPositions();
            
            $this->model->setInfo("Data saved.");
        }
        catch (\Exception $ex) 
        {
            $message = $ex->getMessage();
            $this->model->setError("Error saving data: $message.");
        }
    }
    
    private function UpdateAcademicPositions()
    {
        if ($items = $this->GetItemsFromPostData("dp"))
        {
            $this->model->academicPositions->DeleteItemKeys($this->GetItemKeysToDeleteFromPostData("dp"));
            $this->model->academicPositions->InsertItems($this->GetItemsToInsert($items));
        }
    }
}
