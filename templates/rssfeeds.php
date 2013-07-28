<?php

/*
    Elaborate - A web collaboration engine written in PHP & MySQL
    Copyright (C) 2004 Tim Booker        
    https://github.com/hyperlinkage/elaborate

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

    // output a list of available rss feeds

?>

    <h1><?php print( $data[ 'page' ][ 'title' ] ); ?>

    <dl>
        
<?php
    
    foreach( $data[ 'page' ][ 'feeds' ] as $f ) {
        print( '<dt><a href="?action=rss&amp;tag=' . $f[ 'tag' ] . '">' . $f[ 'title' ] . '</a></dt>' . "\n\n" );
        print( '<dd>' . $f[ 'description' ] . '</dd>' . "\n\n" );
    }

?>
    
    </dl>
    