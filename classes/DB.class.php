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

    class DB {

        function DB($mysqlHost, $mysqlDb, $mysqlUser, $mysqlPass, $mysqlPort) {

            $this->mysqlHost = $mysqlHost;
            $this->mysqlDb   = $mysqlDb;
            $this->mysqlUser = $mysqlUser;
            $this->mysqlPass = $mysqlPass;
            $this->mysqlPort = $mysqlPort;

            // required user privileges
            $this->privileges = array( 'SELECT', 'INSERT', 'UPDATE', 'DELETE', 'CREATE', 'ALTER', 'DROP' );

            $this->active = false;
            $this->queries = array();

            $this->database =  mysqli_connect($this->mysqlHost, $this->mysqlUser, $this->mysqlPass, $this->mysqlDb, $this->mysqlPort);
            
            if($this->database !== false)
            {
                $this->active = true;
            }
        }

        function checkPrivileges() {
            // compare available user privileges to required privilege list
            
            // privilege checking on remote mysql hosts seems to fail, perhaps we have the wrong sql syntax
            if( $this->mysqlHost == 'localhost' ) {
            
                $available = $this->getPrivileges();
    
                if( ! in_array( 'ALL PRIVILEGES', $available ) ) {
                    foreach( $this->privileges as $p ) {                    
                        if( ! in_array( $p, $available ) ) {
                            return false;
                        }
                    }
                }
            }
            return true;
        }

        function getPrivileges() {
            // get a list of available privileges
            
            $p = array();
            
            $grantArray = $this->getRows( 'SHOW GRANTS FOR `' . $this->mysqlUser . '`@`' . $this->mysqlHost . '`' );

            foreach( $grantArray[ 0 ] as $g ) {
                $grants = $g;
            }
            $grants = preg_match( '/GRANT(.*)\bON\b/U', $grants, $matches );
            $grants = explode( ',', $matches[ 1 ] );

            foreach( $grants as $g ) {
                $p[] = trim( $g );
            }
            return $p;
        }

        function query( $mySqlQry ) {

            $this->queries[] = $mySqlQry;

            return mysqli_query($this->database, $mySqlQry);
        }

        function getRows( $mySqlQry ) {

            $this->queries[] = $mySqlQry;

            $qry =  mysqli_query($this->database, $mySqlQry);
            $rows = array();

            while($row = mysqli_fetch_array($qry, MYSQLI_ASSOC))
            {
                $rows[] = $row;
            }

            return $this->stripSlashes( $rows );
        }

        function insertRows( $mySqlQry ) {

            $this->queries[] = $mySqlQry;

            $qry = mysqli_query($this->database, $mySqlQry );

            return mysqli_insert_id($this->database);
        }

        function updateRows( $mySqlQry ) {

            $this->queries[] = $mySqlQry;

            $qry = mysqli_query($this->database, $mySqlQry );

            return mysqli_affected_rows($this->database);
        }

        function deleteRows( $mySqlQry ) {

            $this->queries[] = $mySqlQry;

            $qry = mysqli_query($this->database, $mySqlQry );

            return mysqli_affected_rows($this->database);
        }

        function insertAssoc( $tableName, $assocArray ) {

            $colNames  = array();

            foreach( $assocArray as $key => $val ) {
                $colNames[] = $key;
            }
            $insertQry = 'INSERT INTO ' . $tableName . ' ( `' . implode( '`, `', $colNames ) . '` ) VALUES ( "' . implode( '", "', $assocArray ) . '" );';

            return $this->insertRows( $insertQry );
        }

        function getTables() {

			$tableList = array();
			$tables = $this->getRows("SHOW TABLES");
			
			foreach($tables as $key => $val)
			{
				foreach($val as $k => $v)
				{
					$tableList[] = $v;
				}					
			}
			return $tableList;
        }

        function queryFromFile( $path ) {
            // execute sql queries in an external file

            $sql = file( $path );
            $sql = implode( "\n", $sql );

            $sqlLines = explode( ';', $sql );

            foreach( $sqlLines as $l ) {
                $this->query( $l );
            }
        }

        function stripSlashes( $array ) {

            foreach( $array as $key => $val ) {

                if( is_array( $val ) ) {
                    $array[ $key ] = $this->stripSlashes( $val );
                } else {
                    $array[ $key ] = stripslashes( $val );
                }
            }
            return $array;
        }
    }

?>