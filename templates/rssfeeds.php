<h1><?php print( $data[ 'page' ][ 'title' ] ); ?>

<dl>
        
<?php
    
    foreach( $data[ 'page' ][ 'feeds' ] as $f ) {
        print( '<dt><a href="?action=rss&amp;tag=' . $f[ 'tag' ] . '">' . $f[ 'title' ] . '</a></dt>' . "\n\n" );
        print( '<dd>' . $f[ 'description' ] . '</dd>' . "\n\n" );
    }

?>
    
</dl>
