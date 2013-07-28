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

    // list of available rss feeds

    $data[ 'page' ][ 'title' ] = 'RSS Feeds';
    $data[ 'page' ][ 'type' ] = 'rssfeeds';
    
    $data[ 'page' ][ 'feeds' ] = array( 
        array( 
            'title' => 'Recently Changed Pages',
            'description' => 'Updated whenever a page is updated or added to the site.',
            'tag'   => 'updated'
        ),
        array( 
            'title' => 'New Pages',
            'description' => 'Updated when a new page is created.',
            'tag'   => 'created'
        )
    )
    
?>