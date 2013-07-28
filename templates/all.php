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

?>

<h1><?php print( $data[ 'page' ][ 'title' ] ); ?></h1>

<table>
    <thead>
    <tr>
     <td>Modified</td>
     <td>Name</td>
    </tr>
    </thead>
    
<?php 

    foreach( $data[ 'page' ][ 'content' ] as $p ) {
        print( ' <tr>' );
        print( '  <td>' . readableDate( $p[ 'modified' ] ) . '</a></td>' . "\n" );
        print( '  <td><a href="' . $data[ 'site' ][ 'url' ] . '?page=' . urlencode( $p[ 'title' ] ) . '">' . $p[ 'title' ] . '</a></td>' . "\n" );
        print( ' </tr>' );
    }

?>

</table>
