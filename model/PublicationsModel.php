<?php

namespace gratz;

include "model/ContentModel.php";
include "model/collections/ItemsCollection.php";

include "model/collections/PublicationsCollection.php";

/**
 * Description of ResearchModel
 *
 * @author ondrej.gratz
 */
class PublicationsModel extends \gratz\ContentModel {
    public function __construct($pageName, $isEditor=FALSE) 
    {
        parent::__construct($pageName, $isEditor);
    }
    
    function __destruct() 
    {
        parent::__destruct();
    }
    
    public $publications;
   
    protected function OnLoadData()
    {
        parent::OnLoadData();
        $this->publications = new PublicationsCollection($this->pdo, $this->isEditor);
    }
}
