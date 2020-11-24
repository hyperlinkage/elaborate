<?php

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
