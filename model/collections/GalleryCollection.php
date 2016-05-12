<?php

namespace gratz;


class GalleryCollection extends ItemsCollection 
{
    public function __construct($pdo, $doNotSanitize) 
    {
        $this->baseTableName = "Gallery";
        $this->baseProperties = array("Date", "Title", "FileName");
        $this->orderBy = "Date DESC";

        parent::__construct($pdo, $doNotSanitize);
    }    
    
    protected function GetCollectionTitle()
    {
        return "Gallery";
    }
    
    protected function PrepareItemForDisplay($item)
    {
        parent::PrepareItemForDisplay($item);
        
        $item->ID = filter_var($item->ID, FILTER_SANITIZE_NUMBER_INT);
        $item->Date = filter_var($item->Date, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $item->Title = filter_var($item->Title, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $item->FileName = filter_var($item->FileName, FILTER_SANITIZE_URL);
    }
    
    protected function ValidateItem($item)
    {
        parent::ValidateItem($item);
        
        $item->Date = \DateTime::createFromFormat("d.m.Y", $item->Date);
        if (!$item->Date)
        {
            throw new \GratzValidationException("Valid date must be specified for every Gallery item");
        }
        if (!is_string($item->Title) || strlen($item->Title) == 0)
        {
            throw new \GratzValidationException("Title must be specified for every Gallery item");
        }
        if ((!isset($item->File) || !$item->File))
        {
            throw new \GratzValidationException("File must be uploaded for new Gallery item");
        }
    }
    
    
    protected function OnAfterDeleteItem($id)
    {
        $item = array_filter($this->data, function($v) use($id){
                     return $v->ID === $id;
                 });
        if ($item)
        {
            $fileName = "gallery/" . $item->FileName;
            $thumbName = "gallery/thumbs/tb_" . $item->FileName;
            if (file_exists($fileName))
            {
                unlink($fileName);
            }
            if (file_exists($thumbName))
            {
                unlink($thumbName);
            }
        }
    }
}
