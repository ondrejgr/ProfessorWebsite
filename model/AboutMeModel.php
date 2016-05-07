<?php

namespace gratz;

include "model/ContentModel.php";
include "model/AcademicPosition.php";

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
    
    private $baseTableName = "AcademicPositions";
    private $baseProperties = array("Period", "Position", "Place");
    
    public $academicPositions = array();
    
    private function LoadAcademicPositions()
    {
        $this->academicPositions = array();

        $sth = $this->pdo->query("SELECT * FROM $this->baseTableName ORDER BY Period DESC;", 
                    \PDO::FETCH_CLASS, "\gratz\AcademicPosition");
        if (!$sth)
        {
            throw new \Exception("Unable to load $this->baseTableName");
        }

        while ($academicPosition = $sth->fetch())
        {
            $this->academicPositions[] = $academicPosition;
        }
        $sth->closeCursor();
    }
    
    public function InsertAcademicPositions($items)
    {
        $this->InsertItemsToTable($items, $this->baseTableName, $this->baseProperties);
        $this->LoadAcademicPositions();
    }

    public function DeleteAcademicPositions($items)
    {
        $this->DeleteItemsFromTable($items, $this->baseTableName);
        $this->LoadAcademicPositions();
    }
    
    protected function OnLoadData()
    {
        $this->LoadAcademicPositions();
    }
}
