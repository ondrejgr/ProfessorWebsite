<?php

namespace gratz;

include "model/ContentModel.php";
include "model/collections/ItemsCollection.php";
include "model/collections/GalleryCollection.php";


/**
 * Description of GalleryModel
 *
 * @author ondrej.gratz
 */
class GalleryModel extends \gratz\ContentModel {
    public function __construct($pageName, $isEditor=FALSE) 
    {
        parent::__construct($pageName, $isEditor);
    }
    
    function __destruct() 
    {
        parent::__destruct();
    }
    
    public $gallery;
    
    protected function OnLoadData()
    {
        parent::OnLoadData();
        $this->gallery = new GalleryCollection($this->pdo, $this->isEditor);
    }
}
