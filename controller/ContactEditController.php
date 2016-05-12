<?php
namespace gratz;

class ContactEditController extends BaseController {
    
    public function __construct($model) 
    {
        parent::__construct($model);
    }
    
    public function ProcessPOST()
    {
        try
        {
            $this->UpdateContent();
            
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
    
}
