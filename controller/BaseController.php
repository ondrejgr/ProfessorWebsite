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
    
    private function GetItemsArrayFromData($dp, $arrayTitle)
    {
        if (!array_key_exists("ID", $dp) || !is_array($dp["ID"]))
        {
            throw new \GratzException("Primary key values array is missing in posted $arrayTitle data");
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
    
    protected function GetItemsFromPostData($arrayName, $arrayTitle)
    {
        if (!is_string($arrayName) || strlen($arrayName) == 0)
        {
            throw new \GratzException("Invalid array name passed");
        }
        $dp = filter_input(INPUT_POST, $arrayName, FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
        if (!is_array($dp))
        {
            throw new \GratzException("No $arrayTitle data posted");
        }
        
        $items = $this->GetItemsArrayFromData($dp, $arrayTitle);  
        $this->LoadPropertiesFromData($dp, $items);
      
        return $items;
    }
    
    protected function GetItemsToDelete($items)
    {
        if (!is_array($items))
        {
            throw new \GratzException("No valid items array to delete specified");
        }
        $Filter = function($v)
        {
            return $v->Delete && $v->ID > 0;
        };
        return array_filter($items, $Filter);   
    }
    
    protected function GetItemsToInsert($items)
    {
        if (!is_array($items))
        {
            throw new \GratzException("No valid items array to insert specified");
        }
        $Filter = function($v)
        {
            return !$v->Delete && $v->ID <= 0;
        };
        return array_filter($items, $Filter);   
    }
}
