<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace gratz;

/**
 * Description of NavItemsLoaded
 *
 * @author ondrej.gratz
 */
class NavItemsLoader {
    private $pdo;
    private $isAdminLoggedIn;

    public function __construct($pdo, $isAdminLoggedIn) 
    {
        if (!$pdo)
        {
            throw new \Exception("No PDO object passed to NavItemsLoader constructor");
        }
        $this->pdo = $pdo;
        $this->isAdminLoggedIn = $isAdminLoggedIn;
    }    
    
    private function SanitizeNavItem($item)
    {
        $item->Title = filter_var($item->Title, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $item->Url = filter_var($item->Url, FILTER_SANITIZE_URL);
    }
    
    public function GetNavItems()
    {
        $navItems = array();
        $adminFilter = '';
        if (!$this->isAdminLoggedIn)
        {
            $adminFilter = ' AND IsAdmin = 0';
            $url = 'Name';
        }
        else
        {
            $url = "Name, CASE WHEN IsAdmin = 0 THEN 'Edit' ELSE '' END";
        }
        $sth = $this->pdo->query("SELECT Name, Title, NavIndex, IsAdmin, CONCAT('index.php?view=', " . $url . ") Url " . 
                "FROM Pages WHERE NavIndex > 0" . $adminFilter . " ORDER BY NavIndex;", \PDO::FETCH_OBJ);

        while ($navItem = $sth->fetch())
        {
            $this->SanitizeNavItem($navItem);
            $navItems[] = $navItem;
        }
        $sth->closeCursor();
        
        return $navItems;
    }
    
}
