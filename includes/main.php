<?php

/*
	Elaborate - A web collaboration engine written in PHP & MySQL
	Copyright (C) 2004-2020 Tim Booker        
	https://github.com/hyperlinkage/elaborate

	Contributors: 
		Tim Booker <timbooker@hyperlinkage.com>

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
    include( 'config/config.php' );
    include( 'classes/Session.class.php' );
    include( 'classes/DB.class.php' );
    include( 'classes/DBInstaller.class.php' );
    include( 'classes/Wiki.class.php' );
    include( 'classes/RSS.class.php' );
    include( 'classes/Form.class.php' );
    include( 'classes/User.class.php' );
    include( 'classes/Mail.class.php' );
    include( 'classes/Parsedown.php' );

    $GLOBALS[ 'version' ] = '2020-11-24';

    $GLOBALS[ 'session' ]   = new Session();
    $GLOBALS[ 'db' ]        = new DB($mysqlHostname, $mysqlDatabase, $mysqlUsername, $mysqlPassword, $mysqlPort);
    $GLOBALS[ 'installer' ] = new DBInstaller();
    $GLOBALS[ 'wiki' ]      = new Wiki();
    $GLOBALS[ 'rss' ]       = new RSS();
    $GLOBALS[ 'user' ]      = new User();

    $GLOBALS[ 'data' ] = array(
        'site' => array(
            'title' => $GLOBALS[ 'title' ],
            'url'   => $GLOBALS[ 'url' ]
        ),
        'page' => array()
    );
    
    $user->autoLogIn();

    if( $user->id ) {
        $data[ 'user' ] = array(
            'id' => $user->id,
            'name' => $user->name
        );
    }

    $params = $_GET;
    $action = ( isset( $params[ 'action' ] ) ? $params[ 'action' ] : 'view' );

    if( ! $db->active || ! $installer->isInstalled() || ! $installer->isCurrent() ) {
        // database not available, or incorrect data structure, call installer
        $action = 'install';
    } elseif( ! $user->adminExists() ) {
        // if no admin user exists, point to registration page
        $action = 'register';
    }
    
    $accessRequired = 0;

    // these actions never require a log-in
    $publicFunctions = array( 'install', 'rss', 'login', 'register', 'confirm' );    
    // these require read access
    $readFunctions   = array( 'view', 'all', 'changes', 'search', 'diff', 'rssfeeds', 'about' );    
    // and these require write access
    $writeFunctions  = array( 'edit' );
    
    $readClearance  = ( $user->level >= $readAccess );    
    $writeClearance = ( $user->level >= $writeAccess );

    if( in_array( $action, $readFunctions ) &&  ! $readClearance ) {
        $accessRequired = $readAccess;
    }   
    
    if( in_array( $action, $writeFunctions ) &&  ! $writeClearance ) {
        $accessRequired = $writeAccess;
    }   
    
    if( $accessRequired == 0 ) {
                
        switch( $action ) {
            case 'install' : {
                include( 'includes/install.php' );
                break;
            }                    
            case 'register' : {
                include( 'includes/register.php' );
                break;
            }        
            case 'confirm' : {
                include( 'includes/confirm.php' );
                break;
            }        
            case 'about' : {
                include( 'includes/about.php' );
                break;
            }
            case 'rss' : {
                // get xml data for a feed
                include( 'includes/rss.php' );
                break;
            }
            case 'login' : {
                include( 'includes/login.php' );
                break;
            }
            case 'tools' : {
                include( 'includes/tools.php' );
                break;
            }
            case 'all' : {
                include( 'includes/all.php' );
                break;
            }
            case 'changes' : {
                include( 'includes/changes.php' );
                break;
            }
            case 'search' : {
                include( 'includes/search.php' );
                break;
            }
            case 'diff' : {
                include( 'includes/diff.php' );
                break;
            }
            case 'rssfeeds' : {
                include( 'includes/rssfeeds.php' );
                break;
            }
            case 'edit' : {
                include( 'includes/edit.php' );
                break;
            }
            case 'recent' : {
                include( 'includes/recent.php' );
                break;
            }
            default : {            
                include( 'includes/view.php' );
                break;
            }
        }
        
    } else {

        // not logged-in, call log-in screen
        $session->setVariable( 'destination', $_SERVER[ 'REQUEST_URI' ] );
        include( 'includes/login.php' );
        
    }
    
    // call php templates
    ob_start();
    include( 'templates/main.php' );
    ob_end_flush();

?>