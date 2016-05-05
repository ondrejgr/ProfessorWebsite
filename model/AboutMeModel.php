<?php

namespace gratz;

include "model/ContentModel.php";

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
}
