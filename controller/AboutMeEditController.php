<?php
namespace gratz;

class AboutMeEditController extends BaseController {
    
    public function __construct($model) 
    {
        parent::__construct($model);
    }
    
    public function ProcessPOST()
    {
        if (!isset($_POST['Content']) || !is_string($_POST['Content']))
        {
            throw new GratzException("No content specified");
        }
        $content = filter_input(INPUT_POST, 'Content', FILTER_SANITIZE_STRING);
        $this->model->updateContent($content);
    }
}
