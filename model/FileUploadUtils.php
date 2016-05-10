<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace gratz;

/**
 * Description of UploadUtils
 *
 * @author ondrej.gratz
 */
class FileUploadUtils 
{
    public function CheckImageFormat($image)
    {
        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        if (false === $ext = array_search(
            $finfo->file($image['tmp_name']),
            array(
                'jpg' => 'image/jpeg',
                'png' => 'image/png',
                'gif' => 'image/gif',
            ),
            true
        )) {
            throw new \GratzException('Invalid image format');
        }
    }
    
    public function CheckFileUploadError($image)
    {
        switch ($image['error']) 
        {
            case UPLOAD_ERR_OK:
                break;
            case UPLOAD_ERR_NO_FILE:
                throw new \GratzException('No file sent');
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                throw new \GratzException('Exceeded upload file size limit');
            default:
                throw new \GratzException('Unknown error when uploading file');
        }        
    }
    
    public function IsFilePosted($image)
    {
        if (!isset($image['error']) || is_array($image['error']))
        {
            throw new \GratzException('Unable to upload file');
        }
        return $image['error'] != UPLOAD_ERR_NO_FILE;
    }
    
    public function CheckAndUploadImage($image, $targetFileName)
    {
        if (!is_string($targetFileName) || strlen($targetFileName) == 0)
        {
            throw new \GratzException('Target file name not specified');
        }
        if (!isset($image['error']) || is_array($image['error']))
        {
            throw new \GratzException('Unable to upload file');
        }
        $this->CheckFileUploadError($image);
        $this->CheckImageFormat($image);
        if (!getimagesize($image['tmp_name']))
        {
            throw new \GratzException('Invalid image file uploaded');
        }
        if (!move_uploaded_file($image['tmp_name'], $targetFileName))
        {
            throw new \GratzException('File upload failed');
        }
    }
}
