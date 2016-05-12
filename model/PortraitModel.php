<?php
namespace gratz;

/**
 * Description of Person
 *
 * @author ondrej.gratz
 */
class PortraitModel extends \gratz\BaseModel {
    public function __construct($pageName) 
    {
        parent::__construct($pageName, TRUE);
    }
    
    function __destruct() 
    {
        parent::__destruct();
    }
    
    public $portraitSmallUrl = "img/portrait_small.png";
    public $portraitUrl = "img/portrait.png";
    
    public $portraitSmall;
    public $portrait;
    
    public function setPortraitSmall($image)
    {
        if ($this->fileUploadUtils->IsFilePosted($image))
        {
            $this->fileUploadUtils->CheckAndUploadImage($image, $this->portraitSmallUrl);
        }
    }
    
    public function setPortrait($image)
    {
        if ($this->fileUploadUtils->IsFilePosted($image))
        {
            $this->fileUploadUtils->CheckAndUploadImage($image, $this->portraitUrl);
        }
    }
}
