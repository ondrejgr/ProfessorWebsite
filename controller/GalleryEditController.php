<?php
namespace gratz;

class GalleryEditController extends BaseController {
    
    public function __construct($model) 
    {
        parent::__construct($model);
    }
    
    public function ProcessPOST()
    {
        try
        {
            $this->UpdateContent();
            $this->UpdateGallery();
            
            return "data_saved";
        }
        catch (\Exception $ex) 
        {
            $message = $ex->getMessage();
            $this->model->setError("Error saving data: $message.");
            return FALSE;
        }
    }
    
    private function UpdateContent()
    {
        $content = filter_input(INPUT_POST, 'Content');
        if (!is_string($content))
        {
            throw new \GratzException("No content specified");
        }
        $this->model->updateContent($content);
    }
   
    private function UpdateGallery()
    {
        if (!isset($_FILES))
        {
            throw new \GratzException("No files uploaded");
        }

        $itemKeysToDelete = $this->GetItemKeysToDeleteFromPostData("dp");
        $this->model->gallery->DeleteItemsByKeys($itemKeysToDelete);
        
        $items = $this->GetItemsFromPostData("dp");
        $this->AssignFiles($items);
        
        $itemsToInsert = $this->GetItemsToInsert($items);
        $this->model->gallery->InsertItems($itemsToInsert);
        
        $itemsToUpdate = $this->GetItemsToUpdate($items);
        $this->model->gallery->UpdateItems($itemsToUpdate);
    }
    
    private function GetPostedDataConvertedToArray()
    {
        $files = array();
        $fdata = $_FILES["dp"];
        if (!is_array($fdata['name']) || !is_array($fdata['name']['File']))
        {
            throw new \GratzException("Invalid data format");
        }
        
        for($i = 0; $i < count($fdata['name']['File']); ++$i)
        {
            $files[]=array(
                'name'     => $fdata['name']['File'][$i],
                'error'     => $fdata['error']['File'][$i],
                'tmp_name' => $fdata['tmp_name']['File'][$i]);
        }

        return $files;
    }
    
    private function AssignFiles($items)
    {
        $itemsCount = count($items);
        $files = $this->GetPostedDataConvertedToArray();
        if (count($files) != $itemsCount)
        {
            throw new \GratzException("No file posted for some entries ");
        }
        
        for($i = 0; $i < $itemsCount; ++$i)
        {
            $this->AssignFileToItem($items[$i], $files[$i]);
        }
    }
    
    private function AssignFileToItem($item, $file)
    {
        $item->File = $file;
    }
}
