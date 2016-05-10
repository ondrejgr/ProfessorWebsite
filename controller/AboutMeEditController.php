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
            $this->UpdateContent();

            $this->UpdateAcademicPositions();
            $this->UpdateEducationTraining();
            $this->UpdateHonors();
            
            return "data_saved";
        }
        catch (\Exception $ex) 
        {
            $message = $ex->getMessage();
            $this->model->setError("Error saving data: $message.");
            return FALSE;
        }
    }
    
    private function UpdateContent()
    {
        $content = filter_input(INPUT_POST, 'Content');
        if (!is_string($content))
        {
            throw new \GratzException("No content specified");
        }
        $this->model->updateContent($content);
    }
    
    private function UpdateAcademicPositions()
    {
        $itemKeysToDelete = $this->GetItemKeysToDeleteFromPostData("dp");
        $this->model->academicPositions->DeleteItemsByKeys($itemKeysToDelete);
        
        $items = $this->GetItemsFromPostData("dp");
        
        $itemsToInsert = $this->GetItemsToInsert($items);
        $this->model->academicPositions->InsertItems($itemsToInsert);
        
        $itemsToUpdate = $this->GetItemsToUpdate($items);
        $this->model->academicPositions->UpdateItems($itemsToUpdate);
    }
        
    private function UpdateEducationTraining()
    {
        $itemKeysToDelete = $this->GetItemKeysToDeleteFromPostData("et");
        $this->model->educationTraining->DeleteItemsByKeys($itemKeysToDelete);
        
        $items = $this->GetItemsFromPostData("et");
        
        $itemsToInsert = $this->GetItemsToInsert($items);
        $this->model->educationTraining->InsertItems($itemsToInsert);
        
        $itemsToUpdate = $this->GetItemsToUpdate($items);
        $this->model->educationTraining->UpdateItems($itemsToUpdate);
    }
    
    private function UpdateHonors()
    {
        $itemKeysToDelete = $this->GetItemKeysToDeleteFromPostData("ho");
        $this->model->honors->DeleteItemsByKeys($itemKeysToDelete);
        
        $items = $this->GetItemsFromPostData("ho");
        
        $itemsToInsert = $this->GetItemsToInsert($items);
        $this->model->honors->InsertItems($itemsToInsert);
        
        $itemsToUpdate = $this->GetItemsToUpdate($items);
        $this->model->honors->UpdateItems($itemsToUpdate);
    }
}
