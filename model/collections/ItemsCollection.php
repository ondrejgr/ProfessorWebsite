<?php
namespace gratz;

class ItemsCollection {
    protected $pdo;
    protected $baseTableName;
    protected $baseProperties;
    protected $orderBy;
    
    private $propertyNamesList;
    private $valueNamesList;
    private $setPropertyNamesList;

    private $doNotSanitize;
    
    public $data;
    public $titles;
    
    public $title;

    public function __construct($pdo, $doNotSanitize) 
    {
        $this->pdo = $pdo;
 
        $this->propertyNamesList = implode(", ", $this->baseProperties);
        $this->valueNamesList = implode(", ", array_map(function($v)
        {
            return ":$v";
        }, $this->baseProperties));
        
        $this->setPropertyNamesList = implode(", ", array_map(function($v)
        {
            return "$v = :$v";
        }, $this->baseProperties));

        $this->doNotSanitize = $doNotSanitize;

        $this->titles = $this->GetPropertyTitles();
        $this->title = filter_var($this->GetCollectionTitle(), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $this->Load();
    }
    
    protected function GetSelectSQLFields()
    {
        return "*";
    }
    
    public function Load()
    {
        $this->data = array();
        $orderBy = "";
        if (is_string($this->orderBy) && strlen($this->orderBy) > 0)
        {
            $orderBy = "ORDER BY $this->orderBy";
        }
        
        $sth = $this->pdo->query("SELECT " . $this->GetSelectSQLFields() . " FROM $this->baseTableName $orderBy;", \PDO::FETCH_OBJ);
        if (!$sth)
        {
            throw new \Exception("Unable to load $this->baseTableName");
        }

        while ($item = $sth->fetch())
        {
            $this->OnItemLoaded($item);
            if (!$this->doNotSanitize)
            {
                $this->PrepareItemForDisplay($item);
            }
            $this->data[] = $item;
        }
        $sth->closeCursor();
    }
    
    protected function GetPropertyTitles()
    {
        return array();
    }
    
    protected function GetCollectionTitle()
    {
        return \get_class($this);
    }
    
    protected function PrepareItemForDisplay($item)
    {
        if (!$item)
        {
            throw new \GratzException("Unable to sanitize NULL object");
        }
    }
    
    private function ValidateItems($items)
    {
        foreach ($items as $item)
        {
            $this->ValidateItem($item);
        }
    }
    
    protected function ValidateItem($item)
    {
        if (!$item)
        {
            throw new \GratzValidationException("Unable to validate NULL object");
        }
    }
    
    private function CheckItemInsertable($item)
    {
        if (!$item)
        {
            throw new \GratzValidationException("Unable to insert NULL object");
        }
        if (isset($item->ID) && $item->ID > 0)
        {
            throw new \GratzValidationException("Unable to insert object with primary key specified");            
        }
    }

    private function CheckItemUpdateable($item)
    {
        if (!$item)
        {
            throw new \GratzValidationException("Unable to update NULL object");
        }
        $id = filter_var($item->ID, FILTER_VALIDATE_INT);
        if (!$id)
        {
            throw new \GratzValidationException("Unable to update object without valid primary key");            
        }
        $item->ID = $id;            
    }
    
    protected function UnsetExtraProps(&$obj)
    {
    
    }
    
    protected function OnItemLoaded($item)
    {
        
    }
    
    public function InsertItems($items)
    {
        if (!is_array($items) || count($items) == 0)
        {
            return FALSE;
        }

        $this->ValidateItems($items);
        $sth = $this->pdo->prepare("INSERT INTO $this->baseTableName ($this->propertyNamesList) VALUES ($this->valueNamesList);");
        foreach($items as $item)
        {
            $this->CheckItemInsertable($item);
            $obj = (array)$item;
            unset($obj["ID"]);
            $this->UnsetExtraProps($obj);
     
            $sth->execute($obj);
            
            $this->OnAfterInsertItem($item);
        }

        $this->Load();
    }
    
    public function UpdateItems($items)
    {
        if (!is_array($items) || count($items) == 0)
        {
            return FALSE;
        }

        $this->ValidateItems($items);
        
        $sth = $this->pdo->prepare("UPDATE $this->baseTableName SET $this->setPropertyNamesList WHERE ID = :ID;");
        foreach($items as $item)
        {
            $this->CheckItemUpdateable($item);
            $obj = (array)$item;
            $this->UnsetExtraProps($obj);
            
            $sth->execute($obj);
        }

        $this->Load();
    }
    
    public function DeleteItemsByKeys($keys)
    {
        if (!is_array($keys) || count($keys) == 0)
        {
            return FALSE;
        }
        
        $sth = $this->pdo->prepare("DELETE FROM $this->baseTableName WHERE ID = :ID;");
        foreach($keys as $id)
        {
            $sth->execute(array(':ID' => $id));
            $this->OnAfterDeleteItem($id);
        }

        $this->Load();
    }
    
    protected function OnAfterInsertItem($item)
    {
        
    }
    
    protected function OnAfterDeleteItem($id)
    {
        
    }
}
