<?php

namespace gratz;

include "model/ContentModel.php";
include "model/collections/ItemsCollection.php";

include "model/collections/ResearchProjectsCollection.php";

/**
 * Description of ResearchModel
 *
 * @author ondrej.gratz
 */
class ResearchModel extends \gratz\ContentModel {
    public function __construct($pageName, $isEditor=FALSE) 
    {
        parent::__construct($pageName, $isEditor);
    }
    
    function __destruct() 
    {
        parent::__destruct();
    }
    
    public $researchProjects;
   
    protected function OnLoadData()
    {
        parent::OnLoadData();
        $this->researchProjects = new ResearchProjectsCollection($this->pdo, $this->isEditor);
    }
}
