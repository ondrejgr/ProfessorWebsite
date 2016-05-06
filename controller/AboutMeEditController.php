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
        if (!is_array($dp["ID"]))
        {
            throw new \GratzException("No academicPositions.ID data specified");
        }
        if (!is_array($dp["Period"]))
        {
            throw new \GratzException("No academicPositions.Period data specified");
        }
        if (!is_array($dp["Position"]))
        {
            throw new \GratzException("No academicPositions.Position data specified");
        }
        if (!is_array($dp["Place"]))
        {
            throw new \GratzException("No academicPositions.Place data specified");
        }
        
        $object = new \stdClass();
        foreach ($dp as $key => $value)
        {
            $object->{$key} = $value;
            foreach ($object as $item)
            {
                echo $item[0];
            }
        }
        
        
        
        die();
    }
}
