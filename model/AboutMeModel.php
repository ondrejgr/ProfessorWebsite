<?php

namespace gratz;

include "model/ContentModel.php";
include "model/ItemsCollection.php";

/**
 * Description of AboutMeModel
 *
 * @author ondrej.gratz
 */
class AboutMeModel extends \gratz\ContentModel {
    public function __construct($pageName) 
    {
        parent::__construct($pageName);
    }
    
    function __destruct() 
    {
        parent::__destruct();
    }
    
    public $academicPositions;
   
    protected function OnLoadData()
    {
        $this->academicPositions = new \gratz\ItemsCollection($this->pdo, "AcademicPositions", 
            array("Period", "Position", "Place"), "Period DESC");
    }
}
