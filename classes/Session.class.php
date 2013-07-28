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

    class Session {

        function Session( $sessionId = false ) {
            if( $sessionId ) {
                session_id( $sessionId );
            }
            session_start();
        }

        function getId() {
            return session_id();
        }

        function getVariable( $varName ) {
            return ( isset( $_SESSION[ $varName ] ) ? $_SESSION[ $varName ] : null );
        }

        function setVariable( $varName, $varContent ) {
            $_SESSION[ $varName ] = $varContent;
        }

        function unsetVariable( $varName ) {
            if( isset( $_SESSION[ $varName ] ) ) {
                unset( $_SESSION[ $varName ] );
                session_unregister( $varName );
            }
        }
    }

?>
