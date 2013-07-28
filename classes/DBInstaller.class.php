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

    class DBInstaller {
        
        function DBInstaller() {
        
            $this->db = & $GLOBALS[ 'db' ];            
            $this->versionTable = 'elaborate_installation';            
            
            $this->sqlDir = 'install/';         
        }
        
        function isInstalled() {                
            // check that the db is installed
        
            $tables = $this->db->getTables();
            
            return in_array( $this->versionTable, $tables );
        }
        
        function isCurrent() {
            // check whether database matches the required version number            
            
            if( $this->getInstalledVersion() < $this->getVersion() ) {            
                return false;
            }
            return true;
        }
        
        function getInstalledVersion() {        
            // find db version number currently installed
        
            $versionRows = $this->db->getRows( 'SELECT * FROM `' . $this->versionTable . '`' );
            
            if( count( $versionRows ) > 0 ) {
                return $versionRows[ 0 ][ 'version' ];
            }
            return 0;
        }
        
        function getVersion() {
            // find db version number needed for the software
            
            $ver = 0;
                        
            if( $handle = opendir( $this->sqlDir ) ) {
               while( false !== ( $file = readdir( $handle ) ) ) {
                   if( substr( $file, 0, 1 ) == 'r' ) {
                        $num = intval( substr( $file, 1 ) );
                        if( $num > $ver ) {
                            $ver = $num;
                        }
                   }
               }
               closedir( $handle );
            }                
            return $ver;
        }
        
        function install() {

            // run sql to set up clean database
            $this->db->queryFromFile( $this->sqlDir . 'full.sql' );
            
            // create version tracking table
            $this->db->query( 'DROP TABLE IF EXISTS `' . $this->versionTable . '`' );
            $this->db->query( 'CREATE TABLE `' . $this->versionTable . '` ( `version` int(11) NOT NULL default "0" ) TYPE=MyISAM' );
            $this->db->insertRows( 'INSERT INTO `' . $this->versionTable . '` VALUES ( "' . $this->getVersion() . '" )' );
        }
        
        function upgrade() {
            // run db upgrade

            $currentVersion = $this->getInstalledVersion();
            $targetVersion = $this->getVersion();
           
            // get list of revision files
            $ver = 0;
            $files = array();

            if( $handle = opendir( $this->sqlDir ) ) {
               while( false !== ( $file = readdir( $handle ) ) ) {
                   if( substr( $file, 0, 1 ) == 'r' ) {
                        $num = intval( substr( $file, 1 ) );
                        if( $num > $currentVersion ) {
                            $files[ $num ] = $file;
                        }
                   }
               }
               closedir( $handle );
            }
            
            // run required files sequentially            
            foreach( $files as $f ) {
                $this->db->queryFromFile( $this->sqlDir . $f );
            }
            
            // update db with new version number
            $this->db->updateRows( 'UPDATE `' . $this->versionTable . '` SET version = ' . $targetVersion );        
        }        
    }
        
?>