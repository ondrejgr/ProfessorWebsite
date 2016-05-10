<?php

namespace gratz;


class AcademicPositionsCollection extends ItemsCollection 
{
    public function __construct($pdo, $doNotSanitize) 
    {
        $this->baseTableName = "AcademicPositions";
        $this->baseProperties = array("Period", "Position", "Place");
        $this->orderBy = "Period DESC";

        parent::__construct($pdo, $doNotSanitize);
    }    
    
    protected function GetCollectionTitle()
    {
        return "Academic Positions";
    }
    
    protected function PrepareItemForDisplay($item)
    {
        parent::PrepareItemForDisplay($item);
        
        $item->ID = filter_var($item->ID, FILTER_SANITIZE_NUMBER_INT);
        $item->Period = filter_var($item->Period, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $item->Position = filter_var($item->Position, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $item->Place = filter_var($item->Place, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    }
    
    protected function ValidateItem($item)
    {
        parent::ValidateItem($item);
        
        if (!is_string($item->Period) || strlen($item->Period) == 0)
        {
            throw new \GratzValidationException("Period must be specified for every Academic position");
        }
        if (!is_string($item->Position) || strlen($item->Position) == 0)
        {
            throw new \GratzValidationException("Position must be specified for every Academic position");
        }
    }
}
