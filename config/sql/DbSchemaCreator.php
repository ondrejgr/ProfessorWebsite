<?php
require 'include/Database.php';

class DbSchemaCreator
{
    private $pdo = NULL;
    private $script_dir = NULL;
    
    private function PutMsg($message, $is_error = FALSE)
    {
        if ($is_error)
        {
            echo "                <li class=\"result_error\">$message</li>\n";
        }
        else
        {
            echo "                <li class=\"result_success\">$message</li>\n";
        }
    }

    private function ProcessFiles($filenames)
    {
        if (!is_array($filenames) || (count($filenames) == 0)) 
        {
            throw new Exception("No files found");
        }

        foreach ($filenames as $filename)
        {
            try
            {
                ## TODO: execute;
                $this->PutMsg("Executing \"" . $filename . "\"...OK");
            } 
            catch (Exception $ex) 
            {
                $errmsg = $ex->getMessage();
                throw new Exception("Executing \"" .$filename . "\" script...ERROR: " . $errmsg . ".");
            }
        }
    }
    
    private function ProcessScripts()
    {
        try
        {
            $this->ProcessFiles(glob($this->script_dir . "create*.sql"));
            $this->PutMsg("Reading SQL scripts...OK");
        } 
        catch (Exception $ex) 
        {
            $errmsg = $ex->getMessage();
            throw new Exception("Reading SQL scripts...ERROR: " . $errmsg . ".");
        }
    }
    
    private function OpenDbConnection()
    {
        try
        {
            $pdo = Database::GetPDO();
            $this->PutMsg("Opening database connection...OK");
            
            return $pdo;
        } 
        catch (Exception $ex) 
        {
            $errmsg = $ex->getMessage();
            throw new Exception("Opening database connection...ERROR: " . $errmsg . ".");
        }
    }
    
    private function SetScriptDir($script_dir)
    {
        if (!is_string($script_dir)) 
        {
            throw new Exception("No script dir specified");
        }
        if (strlen($script_dir) > 0)
        {
            $lastchar = substr($script_dir, -1);
            if ($lastchar != '/') 
            {
                $script_dir = $script_dir . "/";
            }
        }
        $this->script_dir = $script_dir;
    }
    
    function CreateDbSchema($script_dir)
    {
        $this->SetScriptDir($script_dir);
        
        echo "\n        <ul id=\"results\">\n";
        $this->PutMsg("Database schema creation starting...");
        try
        {
            $this->pdo = $this->OpenDbConnection();
            $this->ProcessScripts();
            $this->PutMsg("Database schema creation finished.");
        } 
        catch (Exception $ex)
        {
            $this->PutMsg($ex->getMessage(), TRUE);
        }
        echo "\n        </ul>\n";
        $this->pdo = NULL;
    }
}
