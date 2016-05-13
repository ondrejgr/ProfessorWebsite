<?php

namespace gratz;


class PublicationsCollection extends ItemsCollection 
{
    public function __construct($pdo, $doNotSanitize) 
    {
        $this->baseTableName = "Publications";
        $this->baseProperties = array("PubType", "Year", "Month", "Title", "Author", "Detail");
        $this->orderBy = "Year DESC, Month";

        parent::__construct($pdo, $doNotSanitize);
    }    
    
    protected function GetCollectionTitle()
    {
        return "";
    }
    
    protected function PrepareItemForDisplay($item)
    {
        parent::PrepareItemForDisplay($item);
        
        $item->ID = filter_var($item->ID, FILTER_SANITIZE_NUMBER_INT);
        $item->PubType = filter_var($item->PubType, FILTER_SANITIZE_NUMBER_INT);
        $item->Year = filter_var($item->Year, FILTER_SANITIZE_NUMBER_INT);
        $item->Month = filter_var($item->Month, FILTER_SANITIZE_NUMBER_INT);
        $item->Title = filter_var($item->Title, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $item->Author = filter_var($item->Author, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $item->Detail = filter_var($item->Detail, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    }
    
    protected function ValidateItem($item)
    {
        parent::ValidateItem($item);
        
        $item->Year = filter_var($item->Year, FILTER_VALIDATE_INT);
        if (!is_int($item->Year) || $item->Year < 1900 || $item->Year > 2100)
        {
            throw new \GratzValidationException("Year (1900-2100) must be specified for every Publication");
        }

        $item->Month = filter_var($item->Month, FILTER_VALIDATE_INT);
        if (!is_int($item->Month) || $item->Month < 1 || $item->Month > 12)
        {
            throw new \GratzValidationException("Month (1-12) must be specified for every Publication");
        }
        $item->PubType = filter_var($item->PubType, FILTER_VALIDATE_INT);
        if (!is_int($item->PubType))
        {
            throw new \GratzValidationException("Publication type must be specified for every Publication");
        }
        if (!is_string($item->Title) || strlen($item->Title) == 0)
        {
            throw new \GratzValidationException("Title must be specified for every Publication");
        }
        if (!is_string($item->Author) || strlen($item->Author) == 0)
        {
            throw new \GratzValidationException("Author must be specified for every Publication");
        }
    }
}
