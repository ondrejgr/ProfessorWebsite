<?php
namespace gratz;


class ItemsCollection {
    private $pdo;
    private $baseTableName;
    private $baseProperties;
    private $orderBy;
    
    private $propertyNamesList;
    private $valueNamesList;
    
    public $data = array();

    public function __construct($pdo, $baseTableName, $baseProperties, $orderBy = "") 
    {
        $this->pdo = $pdo;
        $this->baseTableName = $baseTableName;
        $this->baseProperties = $baseProperties;
        $this->orderBy = $orderBy;
  
        $this->propertyNamesList = implode(", ", $this->baseProperties);
        $this->valueNamesList = implode(", ", array_map(function($v)
        {
            return ":$v";
        }, $this->baseProperties));

        $this->Load();
    }
    
    public function Load()
    {
        $this->data = array();
        $orderBy = "";
        if (is_string($this->orderBy) && strlen($this->orderBy) > 0)
        {
            $orderBy = "ORDER BY $this->orderBy";
        }
        
        $sth = $this->pdo->query("SELECT * FROM $this->baseTableName $orderBy;", \PDO::FETCH_OBJ);
        if (!$sth)
        {
            throw new \Exception("Unable to load $this->baseTableName");
        }

        while ($item = $sth->fetch())
        {
            $this->data[] = $item;
        }
        $sth->closeCursor();
    }
    
    private function GetPrimaryKeysOfItems($items)
    {
        $GetID = function($v)
        {
            return $v->ID;
        };
        
        return array_map($GetID, $items);
    }
    
    public function InsertItems($items)
    {
        if (!is_array($items))
        {
            throw new \Exception("Unable to insert items. No valid items array passed");
        }
        if (count($items) == 0)
        {
            return;
        }
        
        $sth = $this->pdo->prepare("INSERT INTO $this->baseTableName ($this->propertyNamesList) VALUES ($this->valueNamesList);");

        foreach($items as $item)
        {
            $obj = (array)$item;
            unset($obj["ID"]);
            $sth->execute($obj);
        }
        $this->Load();
    }
    
    public function DeleteItemKeys($keys)
    {
        if (!is_array($keys))
        {
            throw new \Exception("Unable to delete items. No valid keys array passed");
        }
        if (count($keys) == 0)
        {
            return;
        }
        
        $sth = $this->pdo->prepare("DELETE FROM $this->baseTableName WHERE ID = :ID;");
        foreach($keys as $id)
        {
            $sth->execute(array(':ID' => $id));
        }
        $this->Load();
    }
}
