<?php
namespace gratz;

class ResearchEditController extends BaseController {
    
    public function __construct($model) 
    {
        parent::__construct($model);
    }
    
    public function ProcessPOST()
    {
        try
        {
            $this->UpdateContent();

            $this->UpdateProjects();
            
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
    
    private function UpdateProjects()
    {
        $itemKeysToDelete = $this->GetItemKeysToDeleteFromPostData("dp");
        $this->model->researchProjects->DeleteItemsByKeys($itemKeysToDelete);
        
        $items = $this->GetItemsFromPostData("dp");
        
        $itemsToInsert = $this->GetItemsToInsert($items);
        $this->model->researchProjects->InsertItems($itemsToInsert);
        
        $itemsToUpdate = $this->GetItemsToUpdate($items);
        $this->model->researchProjects->UpdateItems($itemsToUpdate);
    }
}
