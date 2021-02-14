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

    // display contents of a page

    $pageName = ( isset( $params[ 'page' ] ) ? $params[ 'page' ] : '' );

    $currPage = $wiki->getPageWithLinks( $pageName );

    if( count( $currPage ) > 0 ) {
        $data[ 'page' ] = $currPage;
    } else {

        $alt = $wiki->getPageAlternative( $pageName );

        if( count( $alt ) > 0 ) {
        
            // a page used to have the requested name, display friendly error message
            $data[ 'page' ][ 'title' ] = 'Page Not Found';
            $data[ 'page' ][ 'content' ] = 'This system does not contain a page called <em>' . $pageName . '</em>, although a page with that name used to exist.  The following link points to the possible new location of the content:';
            $data[ 'page' ][ 'alt' ] = $alt[ 'title' ];

        } else {
            $data[ 'page' ][ 'title' ] = 'Page Not Found';
            $data[ 'page' ][ 'content' ] = 'This system does not contain a page called <em>' . $pageName . '</em>.';
        }
    }

    $data[ 'page' ][ 'type' ] = 'view';
	
	$data[ 'page' ][ 'incoming' ] = $wiki->whatLinksHere($pageName);
    
?>