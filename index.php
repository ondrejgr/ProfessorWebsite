<?php require 'include/ErrorHandling.php' ?>
<?php
    try
    {
        function GetViewNames()
        {
            $viewNames = array();
            
            $fileNames = glob("view/" . "*View.php");    
            if (!is_array($fileNames) || (count($fileNames) == 0)) 
            {
                throw new \Exception("No views found");
            }
                    
            foreach ($fileNames as $fileName)
            {
                if (is_file($fileName))
                {
                    $viewNames[] = substr($fileName, 5, strlen($fileName) - 13);
                }
            }
            
            return $viewNames;
        }
        
        function DispatchRequest()
        {
            if (isset($_GET['view']) && is_string($_GET['view']))
            {
                $viewName = filter_input(INPUT_GET, 'view');
            }
            else 
            {
                $viewName = "AboutMe";
            }
            
            if (!isset($viewName) || !is_string($viewName) || strlen($viewName) == 0) 
            {
                throw new \GratzException("No view name specified");
            }
            
            $viewNames = GetViewNames();
            if (!in_array($viewName, $viewNames)) 
            {
                throw new \GratzException("Requested view was not found");
            }

            $viewFileName = "view/" . $viewName . "View.php";
            include $viewFileName;
        }
        
        DispatchRequest();
    }
    catch (\Exception $ex) 
    {
        $message = $ex->getMessage();
        include 'include/FatalError.php';
    }
