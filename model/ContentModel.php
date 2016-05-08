<?php

namespace gratz;

class ContentModel extends \gratz\BaseModel {
    public function __construct($pageName, $isEditor=FALSE) 
    {
        parent::__construct($pageName, $isEditor);
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
    
    public function updateContent($content)
    {
        $sth = $this->pdo->prepare("INSERT INTO ContentPages (Name, Content) VALUES (:Name, :Content) ON DUPLICATE KEY UPDATE Content = :Content;");
        $sth->execute(array(':Name' => $this->pageName, ':Content' => $content));
        $this->setContent($content);
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
