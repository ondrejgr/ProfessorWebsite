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
        return "";
    }
    
    protected function PrepareItemForDisplay($item)
    {
        parent::PrepareItemForDisplay($item);
        
        $item->ID = filter_var($item->ID, FILTER_SANITIZE_NUMBER_INT);
        $item->Date = filter_var($item->Date, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $item->Title = filter_var($item->Title, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $item->FileName = filter_var($item->FileName, FILTER_SANITIZE_URL);
    }
    
    protected function OnItemLoaded($item)
    {
        $date = \DateTime::createFromFormat("Y-m-d H:i:s", $item->Date);
        $item->Date = $date->format("d.m.Y");
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
        if (($item->ID < 0) && (!isset($item->File) || !$item->File))
        {
            throw new \GratzValidationException("File must be uploaded for new Gallery item");
        }
        if (isset($item->File) && $item->File)
        {
            $this->UploadFileOnInsertOrUpdate($item);
        }
        if (!is_string($item->FileName))
        {
            throw new \GratzValidationException("FileName must be specified for every Gallery item");
        }
    }    
    
    protected function UnsetExtraProps(&$obj) 
    {
        unset($obj["File"]);
        $obj["Date"] = $obj["Date"]->format("Y-m-d H:i:s");
    }
    
    private function CreateThumbnail($source, $dest)
    {
        return copy($source, $dest);
    }
    
    private function UploadFileOnInsertOrUpdate($item)
    {
        if (FileUploadUtils::IsFilePosted($item->File))
        { 
            $ext = FileUploadUtils::GetImageExtension($item->File);
            $item->FileName = sha1_file($item->File['tmp_name']) . "." . $ext;
            $fileName = "gallery/" . $item->FileName;
            $tbFileName = "gallery/thumbs/tb_" . $item->FileName; 
            FileUploadUtils::CheckAndUploadImage($item->File, $fileName);
            $this->CreateThumbnail($fileName, $tbFileName);
        }
    }
    
    private function GetNumberOfFileNames($fileName)
    {
        $items = array_filter($this->data, function($v) use($fileName){
                     return $v->FileName === $fileName;
                 });     
        return count($items);
    }
    
    protected function OnAfterDeleteItem($id)
    {
        $items = array_filter($this->data, function($v) use($id){
                     return $v->ID === $id;
                 });          
        foreach($items as $item)
        {
            if ($this->GetNumberOfFileNames($item->FileName) > 1)
            {
                continue;
            }

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
