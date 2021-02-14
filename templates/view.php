<h1><?php print( $data[ 'page' ][ 'title' ] ); ?></h1>

<?php print( $data[ 'page' ][ 'content' ] ); ?>

<?php 
    
    if( isset( $data[ 'page' ][ 'alt' ] ) ) {        
        print '<p><a href="?page=' . urlencode( $data[ 'page' ][ 'alt' ] ) . '">' . $data[ 'page' ][ 'alt' ] . '</a></p>' . "\n\n";
    }


	if($data[ 'page' ][ 'incoming' ]) {
		print "<h3>See Also</h3>";
		print "<ul>";
		foreach( $data[ 'page' ][ 'incoming' ] as $lnk ) {
			print "<li><a href=\"?page=" . $lnk['title'] . "\">" . $lnk['title'] . "</a></li>";
		}
		print "</ul>";
	}

    if( isset( $data[ 'page' ][ 'modified' ] ) ) {
        print '<p class="date">Page updated ' . readableDate( $data[ 'page' ][ 'modified' ] ) . '</p>' . "\n\n"; 
    }

?>