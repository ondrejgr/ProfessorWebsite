<?php

namespace gratz;

class ContentModel extends \gratz\BaseModel {
    public function __construct($pageName) 
    {
        parent::__construct($pageName);
    }
    
    function __destruct() 
    {
       parent::__destruct();
    }
    
    public $content = '';
    
    private function setContent($content)
    {
        $this->content = $content;
    }
    
    protected function OnLoadData()
    {
        $sth = $this->pdo->prepare("SELECT Content FROM ContentPages WHERE Name = :Name;");
        $sth->execute(array(':Name' => $this->pageName));
        
        $pageData = $sth->fetchColumn();
        if ($pageData)
        {
            $this->setContent($pageData);
        }
        else
        {
            $this->setContent('');
        }
        $sth->closeCursor();
    }
}
