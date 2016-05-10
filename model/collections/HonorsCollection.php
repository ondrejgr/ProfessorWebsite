<?php

namespace gratz;


class HonorsCollection extends ItemsCollection 
{
    public function __construct($pdo, $doNotSanitize) 
    {
        $this->baseTableName = "Honors";
        $this->baseProperties = array("Date", "Title", "Detail");
        $this->orderBy = "Date DESC";

        parent::__construct($pdo, $doNotSanitize);
    }    
    
    protected function GetCollectionTitle()
    {
        return "Honors, Awards & Grants";
    }
    
    protected function PrepareItemForDisplay($item)
    {
        parent::PrepareItemForDisplay($item);
        
        $item->ID = filter_var($item->ID, FILTER_SANITIZE_NUMBER_INT);
        $item->Date = filter_var($item->Date, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $item->Title = filter_var($item->Title, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $item->Detail = filter_var($item->Detail, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    }
    
    protected function ValidateItem($item)
    {
        parent::ValidateItem($item);
        
        if (!is_string($item->Date) || strlen($item->Date) == 0)
        {
            throw new \GratzValidationException("Date must be specified for every Honor entry");
        }
    }
}
