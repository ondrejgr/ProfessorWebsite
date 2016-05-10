<?php
namespace gratz;

class PortraitEditController extends BaseController {
    
    public function __construct($model) 
    {
        parent::__construct($model);
    }
    
    public function ProcessPOST()
    {
        try
        {
            $this->UpdatePortrait();
            
            return "data_saved";
        }
        catch (\Exception $ex) 
        {
            $message = $ex->getMessage();
            $this->model->setError("Error saving data: $message.");
            return FALSE;
        }
    }
    
    private function UpdatePortrait()
    {
        if (!isset($_FILES))
        {
            throw new \GratzException("No files uploaded");
        }
        
        $this->model->setPortraitSmall($_FILES["portraitSmall"]);
        $this->model->setPortrait($_FILES["portrait"]);
    }
}
