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

    // list changes to a page
    
    $data[ 'page' ][ 'type' ] = 'changes';
    $data[ 'page' ][ 'id' ] = ( isset( $params[ 'page' ] ) ? $params[ 'page' ] : '' );

    $page = $wiki->getPageById( $data[ 'page' ][ 'id' ] );

    if( count( $page ) > 0 ) {
    
        $data[ 'page' ][ 'current' ] = $page;
        $data[ 'page' ][ 'title' ] = 'Previous Versions of ' . $data[ 'page' ][ 'current' ][ 'title' ];

        $revisions = $wiki->getRevisions( $data[ 'page' ][ 'id' ] );

        if( count( $revisions ) > 0 ) {
            $data[ 'page' ][ 'revisions' ] = $revisions;            
        }
    
    } else {
        $data[ 'page' ][ 'title' ] = 'Error';
        $data[ 'page' ][ 'content' ] = 'Page not found';
    }

?>