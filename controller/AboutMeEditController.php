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
            $content = filter_input(INPUT_POST, 'Content');
            if (!is_string($content))
            {
                throw new \GratzException("No content specified");
            }
            $this->model->updateContent($content);

            $this->UpdateAcademicPositions();
            
            return "data_saved";
        }
        catch (\Exception $ex) 
        {
            $message = $ex->getMessage();
            $this->model->setError("Error saving data: $message.");
            return FALSE;
        }
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
}
