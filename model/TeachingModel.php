<?php

namespace gratz;

include "model/ContentModel.php";
include "model/collections/ItemsCollection.php";

include "model/collections/TeachingCollection.php";

/**
 * Description of TeachingModel
 *
 * @author ondrej.gratz
 */
class TeachingModel extends \gratz\ContentModel {
    public function __construct($pageName, $isEditor=FALSE) 
    {
        parent::__construct($pageName, $isEditor);
    }
    
    function __destruct() 
    {
        parent::__destruct();
    }
    
    public $teaching;
   
    protected function OnLoadData()
    {
        parent::OnLoadData();
        $this->teaching = new TeachingCollection($this->pdo, $this->isEditor);
    }
}
