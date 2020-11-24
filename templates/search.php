<h1><?php print( $data[ 'page' ][ 'title' ] ); ?></h1>
    
<?php

    if( isset( $data[ 'page' ][ 'results' ] ) ) {
    
        print( '<dl>' . "\n\n" );
        
        foreach( $data[ 'page' ][ 'results' ] as $r ) {        
            print( ' <dt><a href="' . $data[ 'site' ][ 'url' ] . '?page=' . urlencode( $r[ 'title' ] ) . '">' . $r[ 'title' ] . '</a></dt>' . "\n" );
            print( ' <dd>' . $r[ 'context' ] . '</dd>' . "\n\n" );
        }
        print( '</dl>' . "\n" );
        
    } else {
        print( '<p>No pages match your search.</p>' . "\n" );
    }
    
?>
    
