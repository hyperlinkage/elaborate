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

    if( isset( $data[ 'page' ][ 'current' ] ) ) {

        print( '<h1>' . $data[ 'page' ][ 'title' ] . '</h1>' );
        
        if( isset( $data[ 'page' ][ 'revisions' ] ) ) {
        
            print( '<table>' );
    
            foreach( $data[ 'page' ][ 'revisions' ] as $idx => $r ) {
            
                print( ' <tr>' );
                print( '  <td style="padding-right: 20px;">' . readableDate( $r[ 'date' ] ) . '</td>' );
                print( '  <td style="padding-right: 20px;">' . $r[ 'title' ] . '</td>' ); 
                print( '  <td style="padding-right: 20px;"><a href="' . $data[ 'site' ][ 'url' ] . '?action=diff&amp;id=' . $data[ 'page' ][ 'id' ] . '&amp;rev=' . $r[ 'id' ] . '">View changes</a></td>' );
                print( '  <td style="padding-right: 20px;"><a href="' . $data[ 'site' ][ 'url' ] . '?action=edit&amp;id=' . $data[ 'page' ][ 'id' ] . '&amp;rev=' . $r[ 'id' ] . '">Restore</a></td>' );
                print( ' </tr>' );
            }

            print( '</table>' );
            
        } else {
            print( '<p>No changes have been made since the page was created.</p>' );
        }
    } else {
        print( '<h1>Error</h1>' );
        print( '<p>Page not found.</p>' );
    }
    
?>
