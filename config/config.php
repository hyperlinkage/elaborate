<?php

/*
    Elaborate - A web collaboration engine written in PHP & MySQL
    Copyright (C) 2004 Tim Booker        
    http://elaborate.sourceforge.net/

    Contributors: 
        Tim Booker <tim@hyperlinkage.com>

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA

*/

// Site details

// Absolute url to the wiki eg. 'http://www.mysite.com/wiki/'
$GLOBALS[ 'url' ] = ''; 

// Site title used in the page header eg. 'My Wiki'
$GLOBALS[ 'title' ] = ''; 


// MySQL 
// User must have at least the following privileges: SELECT, INSERT, UPDATE, DELETE, CREATE, ALTER, DROP
$GLOBALS[ 'mysqlHostname' ] = ''; // eg. 'localhost'
$GLOBALS[ 'mysqlUsername' ] = '';
$GLOBALS[ 'mysqlPassword' ] = '';
$GLOBALS[ 'mysqlDatabase' ] = '';


// Security Levels 

// Read access level        
//    0 - Everyone can read pages
//    1 - Only registered users can read pages
//    2 - Only admin can read pages   
$GLOBALS[ 'readAccess' ] = 0;
    
// Write access level        
//    0 - Everyone can edit pages
//    1 - Only registered users can edit pages
//    2 - Only admin can edit pages
$GLOBALS[ 'writeAccess' ] = 0;

// Visitors can register an account
$GLOBALS[ 'userRegister' ] = true;

// Send confirmation email to new users, to validate their email address
// Your PHP installation MUST be able to send email for this to work
$GLOBALS[ 'userRegisterConfirm' ] = true;

?>