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
            throw new \GratzException("No content specified");
        }
        $content = filter_input(INPUT_POST, 'Content', FILTER_SANITIZE_STRING);
        $this->model->updateContent($content);
        
        $this->ProcessAcademicPositions();
    }
    
    private function ProcessAcademicPositions()
    {
        if (!isset($_POST['dp']) || !is_array($_POST['dp']))
        {
            throw new \GratzException("No academicPositions data specified");
        }
        $dp = $_POST['dp'];

        $items = array();
        foreach($dp as $row)
        {
            $obj = new \stdClass();
            foreach ($row as $name => $value)
            {
                //echo $name;
                //echo $value;
                $obj->$name = $value;
            }
            
            print_r($obj);
            //echo $obj->Delete;
            echo "\n";
        }
                
        die();
    }
}
