<?php
namespace gratz;

class AboutMeEditController extends BaseController {
    
    public function __construct($model) 
    {
        parent::__construct($model);
    }
    
    public function ProcessPOST()
    {
        $content = filter_input(INPUT_POST, 'Content', FILTER_SANITIZE_STRING);
        if (!is_string($content))
        {
            throw new \GratzException("No content specified");
        }
        $this->model->updateContent($content);
        
        $this->ProcessAcademicPositions();
    }
    
    private function ProcessAcademicPositions()
    {
        $items = $this->GetItemsFromPostData("dp", "Academic positions");
        $this->model->DeleteAcademicPositions($this->GetItemsToDelete($items));
        $this->model->InsertAcademicPositions($this->GetItemsToInsert($items));
        die();
    }
}
