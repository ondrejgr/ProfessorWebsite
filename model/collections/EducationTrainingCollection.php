<?php

namespace gratz;


class EducationTrainingCollection extends ItemsCollection 
{
    public function __construct($pdo, $doNotSanitize) 
    {
        $this->baseTableName = "EducationTraining";
        $this->baseProperties = array("Degree", "Year", "Position", "Place");
        $this->orderBy = "Year DESC";

        parent::__construct($pdo, $doNotSanitize);
    }    
    
    protected function PrepareItemForDisplay($item)
    {
        parent::PrepareItemForDisplay($item);
        
        $item->ID = filter_var($item->ID, FILTER_SANITIZE_NUMBER_INT);
        $item->Degree = filter_var($item->Degree, FILTER_SANITIZE_STRING);
        $item->Year = filter_var($item->Year, FILTER_SANITIZE_NUMBER_INT);
        $item->Position = filter_var($item->Position, FILTER_SANITIZE_STRING);
        $item->Place = filter_var($item->Place, FILTER_SANITIZE_STRING);
    }
    
    protected function ValidateItem($item)
    {
        parent::ValidateItem($item);
        
        if (!is_string($item->Degree) || strlen($item->Degree) == 0)
        {
            throw new \GratzValidationException("Degree must be specified for every Education & training");
        }
        
        $item->Year = filter_var($item->Year, FILTER_VALIDATE_INT);
        if (!is_int($item->Year) || $item->Year < 1900 || $item->Year > 2100)
        {
            throw new \GratzValidationException("Year (1900-2100) must be specified for every Education & training");
        }
    }
}
