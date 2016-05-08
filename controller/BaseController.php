<?php
namespace gratz;

class BaseController {
    protected $model;
    
    public function __construct($model) 
    {
        if (is_null($model) || !($model instanceof \gratz\BaseModel))
        {
            throw new \Exception("No valid model instance has been passed to controler");
        }
        $this->model = $model;
    }
    
  
    public function ProcessPOST()
    {
        throw new \Exception("POST operation is not implemented");        
    }
    
    public function ProcessGET()
    {
        
    }
    
    private function CreateItems($dp)
    {
        if (!array_key_exists("ID", $dp) || !is_array($dp["ID"]))
        {
            throw new \GratzException("Primary key values array is missing in posted data");
        }

        $items = array();
        
        foreach ($dp["ID"] as $index => $id)
        {
            $item = new \stdClass();
            $item->ID = $id;
            $items[$index] = $item;
        }
        
        return $items;
    }
    
    private function LoadPropertiesFromData($dp, $items)
    {
        $itemsCount = count($items);
        foreach ($dp as $property => $values)
        {
            if (!is_array($dp[$property]) || count($dp[$property]) != $itemsCount)
            {
                throw new \GratzException("No data posted for property " . $property);
            }
            foreach ($values as $index => $value)
            {
                $items[$index]->$property = $value;
            }
        }        
    }
    
    protected function GetItemsFromPostData($arrayName)
    {
        if (!is_string($arrayName) || strlen($arrayName) == 0)
        {
            throw new \GratzException("Invalid array name passed");
        }
        $dp = filter_input(INPUT_POST, $arrayName, FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
        if (!is_array($dp))
        {
            return FALSE;
        }
        
        $items = $this->CreateItems($dp);  
        $this->LoadPropertiesFromData($dp, $items);
      
        return $items;
    }
    
    protected function GetItemsToInsert($items)
    {
        if (!is_array($items))
        {
            return array();
        }
        $Filter = function($v)
        {
            return $v->ID <= 0;
        };
        return array_filter($items, $Filter);   
    }
    
    protected function GetItemsToUpdate($items)
    {
        if (!is_array($items))
        {
            return array();
        }
        $Filter = function($v)
        {
            return $v->ID > 0;
        };
        return array_filter($items, $Filter);   
    }
    
    protected function GetItemKeysToDeleteFromPostData($arrayName)
    {
        if (!is_string($arrayName) || strlen($arrayName) == 0)
        {
            throw new \GratzException("Invalid array name passed");
        }
        $dp = filter_input(INPUT_POST, $arrayName . "Delete", FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

        $result = array();
        if (is_array($dp))
        {
            foreach($dp as $id)
            {
                if ($id > 0)
                {
                    $result[] = $id;
                }
            }
        }
      
        return $result;
    }
    
}
