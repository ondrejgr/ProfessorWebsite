<?php

namespace gratz;


class TeachingCollection extends ItemsCollection 
{
    public function __construct($pdo, $doNotSanitize) 
    {
        $this->baseTableName = "Teaching";
        $this->baseProperties = array("Period", "Title", "Detail");
        $this->orderBy = "Period";

        parent::__construct($pdo, $doNotSanitize);
    }    
    
    protected function GetCollectionTitle()
    {
        return "Lectures";
    }
    
    protected function PrepareItemForDisplay($item)
    {
        parent::PrepareItemForDisplay($item);
        
        $item->ID = filter_var($item->ID, FILTER_SANITIZE_NUMBER_INT);
        $item->Period = filter_var($item->Period, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $item->Title = filter_var($item->Title, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $item->Detail = filter_var($item->Detail, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    }
    
    protected function ValidateItem($item)
    {
        parent::ValidateItem($item);
        
        if (!is_string($item->Period) || strlen($item->Period) == 0)
        {
            throw new \GratzValidationException("Period must be specified for every Lecture");
        }
        if (!is_string($item->Title) || strlen($item->Title) == 0)
        {
            throw new \GratzValidationException("Title must be specified for every Lecture");
        }
    }
}
