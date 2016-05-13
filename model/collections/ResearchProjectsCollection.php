<?php

namespace gratz;


class ResearchProjectsCollection extends ItemsCollection 
{
    public function __construct($pdo, $doNotSanitize) 
    {
        $this->baseTableName = "Research";
        $this->baseProperties = array("Title", "ShortText", "Content");
        $this->orderBy = "ID";

        parent::__construct($pdo, $doNotSanitize);
    }    
    
    protected function GetCollectionTitle()
    {
        return "Research Projects";
    }
    
    protected function PrepareItemForDisplay($item)
    {
        parent::PrepareItemForDisplay($item);
        
        $item->ID = filter_var($item->ID, FILTER_SANITIZE_NUMBER_INT);
        $item->Title = filter_var($item->Title, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $item->ShortText = filter_var($item->ShortText, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $item->Content = filter_var($item->Content, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    }
    
    protected function ValidateItem($item)
    {
        parent::ValidateItem($item);
        
        if (!is_string($item->Title) || strlen($item->Title) == 0)
        {
            throw new \GratzValidationException("Title must be specified for every Research project");
        }
    }
}
