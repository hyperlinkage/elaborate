<?php

/*
    Elaborate - A web collaboration engine written in PHP & MySQL
    Copyright (C) 2004 Tim Booker
    http://elaborate.sourceforge.net/

    Contributors:
        Tim Booker <elaborate@7segment.org>

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

    $data[ 'page' ][ 'type' ] = 'install';
    $data[ 'page' ][ 'title' ] = 'Installation';

    if( ! $db->active ) {

        // mysql connection details not present or incorrect
        $data[ 'page' ][ 'content' ] =
            'A connection to the database could not be established.<br /><br />' .
            'To proceed with installation, please edit <code>config/config.php</code> ' .
            'and insert your MySQL connection details.<br /><br />' .
            'If you are seeing this page repeatedly, please check that your MySQL user ' .
            'account has been granted the privileges listed in the configuration file.';

    } else {

        if( ! $installer->isInstalled() ) {

            if( isset( $_POST[ 'submit' ] ) ) {

                // perform installation of database structure
                $installer->install();

                header( 'Location: ' . $data[ 'site' ][ 'url' ] );
                exit;

            } else {

                // display database creation prompt
                $data[ 'page' ][ 'content' ] =
                    'A connection to the database is available, but the database structure ' .
                    'required by this software is not present.<br /><br />' .
                    'Create database structure now?';

                $data[ 'page' ][ 'confirm' ] = true;
            }

        } elseif( ! $installer->isCurrent() ) {

            if( isset( $_POST[ 'submit' ] ) ) {

                // perform database structure upgrade
                $installer->upgrade();

                header( 'Location: ' . $data[ 'site' ][ 'url' ] );
                exit;

            } else {

                // display database upgrade prompt
                $data[ 'page' ][ 'content' ] =
                    'A connection to the database is available, and it looks like a ' .
                    'previous version of this software used to run here.<br /><br />' .
                    'For this version of the software to run correctly, some updates to ' .
                    'the database structure are needed.  The update is designed to run ' .
                    'without the loss of any existing data, but we strongly recommend ' .
                    'that you back-up your database before proceeding.<br /><br />' .
                    'Update now?';

                $data[ 'page' ][ 'confirm' ] = true;
            }
        } else {
            // no action needed, redirect to home            
            header( 'Location: ' . $data[ 'site' ][ 'url' ] );
        }
    }

?>