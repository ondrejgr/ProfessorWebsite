<?php

namespace gratz;

include "model/ContentModel.php";
include "model/collections/ItemsCollection.php";

include "model/collections/AcademicPositionsCollection.php";
include "model/collections/EducationTrainingCollection.php";
include "model/collections/HonorsCollection.php";

/**
 * Description of AboutMeModel
 *
 * @author ondrej.gratz
 */
class AboutMeModel extends \gratz\ContentModel {
    public function __construct($pageName, $isEditor=FALSE) 
    {
        parent::__construct($pageName, $isEditor);
    }
    
    function __destruct() 
    {
        parent::__destruct();
    }
    
    public $academicPositions;
    public $educationTraining;
    public $honors;
   
    protected function OnLoadData()
    {
        parent::OnLoadData();
        $this->academicPositions = new AcademicPositionsCollection($this->pdo, $this->isEditor);
        $this->educationTraining = new EducationTrainingCollection($this->pdo, $this->isEditor);
        $this->honors = new HonorsCollection($this->pdo, $this->isEditor);
    }
}
