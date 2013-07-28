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

    // get data for an rss feed

    $data[ 'page' ][ 'type' ] = 'rss';
    
    $numItems = 5;  // number of items to include in feed
    $numChars = 255; // numner of characters to include in description field
    
    $feedPages = array();
    
    $tag = ( isset( $params[ 'tag' ] ) ? $params[ 'tag' ] : 'updated' );
    
    switch( $tag ) {
        case 'created' : {
            // build rss feed of recently created pages
        
            // needs improvement
            // the url in the feed should point to a web page listing the most recent pages, not the wiki home page
            $rss->addMetaData( $data[ 'site' ][ 'title' ] . ' : New Pages', '', $data[ 'site' ][ 'url' ] );
            
            $feedPages = $wiki->getNewPageList( $numItems );
            
            break;
        }
        default : {
            // build rss feed of recently updated pages

            // needs improvement
            // the url in the feed should point to a web page listing the most recently updated pages, not the wiki home page
            $rss->addMetaData( $data[ 'site' ][ 'title' ] . ' : Recenty Changed Pages', '', $data[ 'site' ][ 'url' ] );
            
            $feedPages = $wiki->getUpdatedPageList( $numItems );
        }
    }

    foreach( $feedPages as $p ) {
    
        $title = $p[ 'title' ];
        $description = substr( preg_replace( '/\s+/', ' ', strip_tags( $p[ 'content' ] ) ), 0, $numChars );
        $link = $data[ 'site' ][ 'url' ] . '?page=' . urlencode( $p[ 'title' ] );
    
        $rss->addItem( $title, $description, $link );
    }

?>