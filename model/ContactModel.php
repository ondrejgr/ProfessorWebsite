<?php

namespace gratz;

include "model/ContentModel.php";

/**
 * Description of ContactModel
 *
 * @author ondrej.gratz
 */
class ContactModel extends \gratz\ContentModel {
    public function __construct($pageName, $isEditor=FALSE) 
    {
        parent::__construct($pageName, $isEditor);
    }
    
    function __destruct() 
    {
        parent::__destruct();
    }
    

}
