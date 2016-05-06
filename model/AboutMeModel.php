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
    
    public $academicPositions = array();
    
    private function LoadAcademicPositions()
    {
        $this->academicPositions = array();

        $sth = $this->pdo->query("SELECT * FROM AcademicPositions ORDER BY Period DESC;", 
                    \PDO::FETCH_CLASS, "\gratz\AcademicPosition");
        if (!$sth)
        {
            throw new \Exception("Unable to load AcademicPositions");
        }

        while ($academicPosition = $sth->fetch())
        {
            $this->academicPositions[] = $academicPosition;
        }
        $sth->closeCursor();
    }
    
    protected function OnLoadData()
    {
        $this->LoadAcademicPositions();
    }
}
